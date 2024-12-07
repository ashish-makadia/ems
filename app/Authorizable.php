<?php

namespace App;
use Illuminate\Support\Arr;
use Request;

/*
 * A trait to handle authorization based on users permissions for given controller
 */

trait Authorizable
{
    /**
     * Abilities
     *
     * @var array
     */
    private $abilities = [
        'index' => 'view',
        'edit' => 'edit',
        'show' => 'view',
        'update' => 'edit',
        'create' => 'add',
        'store' => 'add',
        'destroy' => 'delete'
    ];

    private $routeName = [
        'rolesandpermissions' => 'roles and permissions',
        'accessips' =>'access ips',
        'logactivity' =>'log activity',
        'orderbooking' =>'order booking',
        
    ];

    /**
     * Override of callAction to perform the authorization before it calls the action
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if( $ability = $this->getAbility($method) ) {
            $this->authorize($ability);
        }
        return parent::callAction($method, $parameters);
    }

    /**
     * Get ability
     *
     * @param $method
     * @return null|string
     */
    public function getAbility($method)
    {
        $routeName = explode('.', Request::route()->getName());
        $action = Arr::get($this->getAbilities(), $method);
        $routeName = $this->checkRouteName($routeName[0]);
        return $action ? $action . ' ' . $routeName : null;
    }

    /**
     * @return array
     */
    private function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * @param array $abilities
     */
    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }

    /**
     * @return route name
     */
    private function checkRouteName($route)
    {
        return isset($this->routeName[$route]) ? $this->routeName[$route] : $route;
    }
}