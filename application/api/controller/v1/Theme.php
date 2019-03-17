<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\Theme as ThemeValidate;
use app\api\model\Theme as ThemeModel;

class Theme extends BaseController{
    protected $beforeActionList = [
        'checkAuth' => ['only'=>'getThemes']
    ];
    
    /*
     * 根据参数 theme 获取主题商品及头图
     * @param string theme['all']['news']['hots']['recommend']['postage']
     * @return ['theInfo'=>,'proInfo'=>,'page=>]
     */
    public function getThemes(){
        (new ThemeValidate())->goCheck();
        $theme = input("param.theme");
        $page = input(("param.page"));
        
        $themeModel = new ThemeModel();
        $rst = $themeModel->getInfoByParam($theme,$page);
        if (empty($rst['proInfo'])){
           return json([
               'proInfo'=>[],
               'theInfo'=>$rst['theInfo'],
               'page' => $page
           ]);
        }else{
            $proInfo = collection($rst['proInfo'])->visible(['pro_id','pro_name','pro_price','topic_img'])->toArray();
            return json([
                'proInfo'=>$proInfo,
                'theInfo'=>$rst['theInfo'],
                'page' => $page
            ]);
        }

    }
    
    
}