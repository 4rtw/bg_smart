<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated=$decorated;
    }

    public function __invoke(array $context=[]):OpenApi
    {
        $openApi=$this->decorated->__invoke($context);
        foreach($openApi->getPaths()->getPaths() as $key=>$path){
            if($path->getGet() && $path->getGet()->getSummary()==='hidden'){
                $openApi->getPaths()->addPath($key,$path->withGet(null));
            }
        }

        $schemas=$openApi->getComponents()->getSecuritySchemes();
        $schemas['cookieAuth']=new \ArrayObject([
            'type'=>'apiKey',
            'in'=>'cookie',
            'name'=>'PHPSESSIID'
        ]);

        $schemas=$openApi->getComponents()->getSchemas();
        $schemas['Credentials']= new \ArrayObject([
            'type'=>'object',
            'properties'=>[
                'username'=>[
                    'type'=>'string',
                    'example'=>'neva@gmail.com',
                ],
                'password'=>[
                    'type'=>'string',
                    'example'=>'1234',
                ]
            ]
        ]);

        $pathItem = new PathItem(null,null,null,null,null,
             new Operation('postApiLogin',['User'],
                 [
                     '200'=> [
                         'description'=>'Utilisateur connecté',
                         'content'=> [
                             'application/json'=> [
                                 'schema'=> [
                                     '$ref'=>'#/components/schemas/User-read.User'
                                 ]
                             ]
                         ]
                     ]
                 ],'','',null,[],
                 new RequestBody('',
                     new \ArrayObject([
                        'application/json'=>[
                            'schema'=>[
                                '$ref'=>'#/components/schemas/Credentials'
                            ]
                        ]
                    ]),false
                ),null,false,null,null,[]
                ),null,null,null,null,null,null,[]
        );

        $openApi->getPaths()->addPath('/api/login',$pathItem);

        return $openApi;
    }
}