<?php

class processcart_bcstep3 extends processInst {
	
	public function __construct(& $caller, $callerName, $stack=null) {
		//echo 'hello process subdir test1';
		
		parent::__construct($caller, $callerName, $stack);
		$this->processStepName = __CLASS__;
		
		//echo 'cart step 3:',$this->caller->status;
	}
 
	//override
	public function nextStep($event=null) {
		return parent::nextStep($event);
	}
	
	//override
	public function prevStep($event=null) {
		return parent::prevStep($event);
	}	
	
	//override
	public function isFinished($event=null) {
		
		if (!parent::isFinished($event)) {
			//$this->stackRunStep();
			return false;
		}	
		
		if ($this->runCode(3, $event)) {
			
			$this->stackRunStep(1);
			return true;
		};
		
		//$this->stackRunStep();
		return false;		
	}	
 
}
?>