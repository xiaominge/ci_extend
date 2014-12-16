<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 文章控制器
 * @author 徐亚坤
 */

import('class.resource_controller');

class Article extends R_Controller implements SplSubject
{

    public function __construct()
    {
        $this->model = 'm_admin_article';
        $this->resource = 'article';
        $this->resourceName = '文章';

        parent::__construct();

        $method = $this->router->fetch_method();
        
        $this->validator = array(
            array(
                'field'   => 'title',
                'label'   => '标题',
                'rules'   => 'required',
            ),
        );
    }

    public function index()
    {
        exit('todo');
    }

}
// end class

/* End of file article.php */
/* Location: ./application/controllers/admin/article.php */