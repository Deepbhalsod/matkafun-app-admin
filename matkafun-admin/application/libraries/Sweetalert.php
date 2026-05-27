<?php
class Sweetalert{

    public $sessionKey="sdfsdgfgdf45e645gd";
    public $js='<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>';
    public function __construct() {
    }

    public function success($msg,$title=Null)
    {
        $title = empty($title)?'Success':$title;
        $this->addMsg('success',$msg,$title);
    }
    public function error($msg,$title=Null)
    {
        $title = empty($title)?'Error':$title;
        $this->addMsg('error',$msg,$title);
    }
    public function info($msg,$title=Null)
    {
        $title = empty($title)?'Info':$title;
        $this->addMsg('info',$msg,$title);
    }
    public function warning($msg,$title=Null)
    {
        $title = empty($title)?'Warning':$title;
        $this->addMsg('warning',$msg,$title);
    }
    public function question($msg,$title=Null)
    {
        $title = empty($title)?'Question':$title;
        $this->addMsg('question',$msg,$title);
    }
    public function addMsg($type,$msg,$title)
    {
        if(empty($_SESSION[$this->sessionKey][$type]))
        {
            $_SESSION[$this->sessionKey][$type] = array();
        }
        $_SESSION[$this->sessionKey][$type][] = ['title'=>$title,'msg'=>$msg];
    }
    public function displayMsg()
    {
        $str = "";
        if(empty($_SESSION[$this->sessionKey]))
        {
            return $str;
        }
        $msgData = $_SESSION[$this->sessionKey];
        $_SESSION[$this->sessionKey]=[];
        unset($_SESSION[$this->sessionKey]);

        foreach($msgData as $key=>$val){
            foreach($val as $sWval)
            {
                $str.="Swal.fire(
                '".$sWval['title']."',
                '".$sWval['msg']."',
                '".$key."'
            );";
            }
        }
        return "<script>$(document).ready(function(e) {".$str."});</script>";
    }
}

/*$SmsClass=new SmsClass;*/