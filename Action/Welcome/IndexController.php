<?php

namespace Cerad\Bundle\TournBundle\Action\Welcome;

use Symfony\Component\HttpFoundation\Request;

use Cerad\Bundle\CoreBundle\Action\ActionController;

class IndexController extends ActionController
{
    public function action(Request $request)
    {   
        if ($this->isGranted('ROLE_USER'))
        {
            return $this->redirectResponse('cerad_tourn__home');
        }
        return $this->redirectResponse('cerad_tourn__welcome');
        
        if ($request);
    }    
}
