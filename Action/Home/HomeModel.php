<?php

namespace Cerad\Bundle\TournBundle\Action\Home;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Cerad\Bundle\CoreBundle\Action\ActionModelFactory;

class HomeModel extends ActionModelFactory
{   
    protected $personRepo;
    
    protected $project;
    protected $person;
    
    public function __construct($personRepo)
    {
        $this->personRepo = $personRepo;
    }
    
    public function getPerson () { return $this->person; }
    public function getProject() { return $this->project; }
    
    public function process()
    {   
        $this->personPlan = $this->person->getPlan($this->project->getKey());
        
        $this->personRepo->flush();
    }
    public function create(Request $request)
    { 
        $this->project = $request->attributes->get('project');
        $this->person  = $request->attributes->get('userPerson');
        
        return $this;
    }
}