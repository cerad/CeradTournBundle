<?php

namespace Cerad\Bundle\TournBundle\Action\Welcome;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class WelcomeModel
{   
    // Injected
    protected $dispatcher;
    protected $project;
    
    public function setDispatcher(EventDispatcherInterface $dispatcher) { $this->dispatcher = $dispatcher; }
    
    public function getProject() { return $this->project; }
    
    public function process()
    {   
    }
    public function create(Request $request)
    { 
        $this->project = $request->attributes->get('project');
        
        return $this;
    }
}