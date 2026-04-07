<?php
class Hello extends CI_Controller
{
  public function index()
  {
    echo "Hello, World" . PHP_EOL;
  }
 
  public function greet($name)
  {
	if(!$this->input->is_cli_request())
     {
         echo "greet my only be accessed from the command line";
         return;
     }
   echo "Hello, $name" . PHP_EOL;
  }
}
