<?php

error_reporting(E_ALL);

/**
 * Specification of the Generis ExtensionInstaller class to add a new behavior:
 * the Modules and Actions in the Ontology at installation time.
 *
 * @author Jerome Bogaerts <jerome@taotesting.com>
 * @package tao
 * @since 2.4
 * @subpackage install
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include common_ext_ExtensionInstaller
 *
 * @author Jerome Bogaerts, <jerome@taotesting.com>
 */
require_once('common/ext/class.ExtensionInstaller.php');

/* user defined includes */
// section 10-13-1-85-74f9b31f:13c8ff1fd35:-8000:0000000000003C57-includes begin
// section 10-13-1-85-74f9b31f:13c8ff1fd35:-8000:0000000000003C57-includes end

/* user defined constants */
// section 10-13-1-85-74f9b31f:13c8ff1fd35:-8000:0000000000003C57-constants begin
// section 10-13-1-85-74f9b31f:13c8ff1fd35:-8000:0000000000003C57-constants end

/**
 * Specification of the Generis ExtensionInstaller class to add a new behavior:
 * the Modules and Actions in the Ontology at installation time.
 *
 * @access public
 * @author Jerome Bogaerts <jerome@taotesting.com>
 * @package tao
 * @since 2.4
 * @subpackage install
 */
class tao_install_ExtensionInstaller
    extends common_ext_ExtensionInstaller
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    // --- OPERATIONS ---

    /**
     * Will create the model of Modules and Actions (MVC) in the persistent
     *
     * @access public
     * @author Jerome Bogaerts <jerome@taotesting.com>
     * @return void
     * @since 2.4
     */
    public function extendedInstall() {
        // section 10-13-1-85-74f9b31f:13c8ff1fd35:-8000:0000000000003C58 begin
        $this->installManagementRole();
        // section 10-13-1-85-74f9b31f:13c8ff1fd35:-8000:0000000000003C58 end
    }
    
    /**
     * Will make the Global Manager include the Management Role of the extension
     * to install (if it exists).
     * 
     * @access public
     * @author Jerome Bogaerts <jerome@taotesting.com>
     * @return void
     * @since 2.4
     */
    public function installManagementRole() {
    	// Try to get a Management Role described by the extension itself.
    	// (this information comes actually from the Manifest of the extension)
    	$role = $this->extension->getManagementRole();
    	
    	$userService = core_kernel_users_Service::singleton();
    	
    	if (empty($role)){
    		// There is no Management role described by the Extension Manifest.
    		// We create a new one with the name of the extension
    		// currently installed.
    		$roleLabel = $this->extension->getID() . ' Manager';
    		$roleClass = new core_kernel_classes_Class(CLASS_MANAGEMENTROLE);
    		$role = $roleClass->createInstance($roleLabel);
    		$backOfficeRole = new core_kernel_classes_Resource(INSTANCE_ROLE_BACKOFFICE);
    		$userService->includeRole($role, $backOfficeRole);
    	}

    	// Take the Global Manager role and make it include
    	// the Management role of the currently installed extension.
    	if ($role->getUri() !== INSTANCE_ROLE_TAOMANAGER){
    		$globalManagerRole = new core_kernel_classes_Resource(INSTANCE_ROLE_TAOMANAGER);
    		$userService->includeRole($globalManagerRole, $role);
    	}
    	
    	// Give the Management role access to all modules of the currently
    	// installed extension.
    	$extAccessService = tao_models_classes_funcACL_ExtensionAccessService::singleton();
    	$extAccessService->add($role->getUri(), $extAccessService->makeEMAUri($this->extension->getID()));
    	
    	common_Logger::i("Management Role " . $role->getUri() . " created for extension '" . $this->extension->getID() . "'.");
    }

} /* end of class tao_install_ExtensionInstaller */

?>