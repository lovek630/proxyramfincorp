<?php
class MY_Loader extends CI_Loader {

    public function template($template_name, $args = array(), $return = FALSE)
    {
        if($return){
            $this->view($template_name, $args);
        }else{
            $this->view('common/header', $args);
            $this->view($template_name, $args);
            $this->view('common/footer', $args);
        }
    }

}

?>