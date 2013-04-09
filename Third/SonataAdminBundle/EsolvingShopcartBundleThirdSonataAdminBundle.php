<?php

namespace Esolving\ShopcartBundle\Third\SonataAdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EsolvingShopcartBundleThirdSonataAdminBundle extends Bundle {

    public function getParent() {
        return 'SonataAdminBundle';
    }

}
