<?php

class MY_Email extends CI_Email {

    /**
     * Get Hostname
     *
     * @access  protected
     * @return  string
     */
    protected function _get_hostname()
    {
        return (isset($_SERVER['HOST_NAME'])) ? $_SERVER['HOST_NAME'] : 'localhost.localdomain';
    }

}
