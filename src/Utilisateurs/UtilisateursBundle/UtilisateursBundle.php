<?php

namespace Utilisateurs\UtilisateursBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UtilisateursBundle extends Bundle
{
	public function getParent(){
	return 'FOSUserBundle';

}
}
