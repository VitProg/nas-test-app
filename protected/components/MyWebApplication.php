<?php

/**
 * Created by PhpStorm.
 * User: VitProg
 * Date: 29.09.2015
 * Time: 15:24
 */
class MyWebApplication extends CWebApplication {

    public function realEnd() {
        if (isset($this->log)) {
            foreach ($this->log->routes as $route) {
                if ($route instanceof CWebLogRoute) {
                    $route->enabled = false;
                }
            }
        }
        $this->end();
    }

}