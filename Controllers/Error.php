<?php


class Errors extends controllers {

    public function error() {
        //   echo "error de controllers";
        $this->view->render($this, "error", null);
    }

}

?>
