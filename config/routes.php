<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\App;
return function (App $app) {

    $app->get('/', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Hello, World!');

        return $response;
    });

    // $app->post('/paymentstatus', \App\V1\Action\CampaignPaymentTrackerAction::class.':status');
    // $app->post('/postcallback', \App\V1\Action\CampaignPaymentTrackerAction::class.':callback');
    // $app->post('/makepayment', \App\V1\Action\CampaignMakePaymentAction::class);


      $app->group("/auth",function($app){
            $app->post('/createuser',  \App\V1\Action\UserCreateAction::class);
            $app->post('/login',  \App\V1\Action\UserLoginAction::class);
            $app->get('/user', \App\V1\Action\AllUsersGetterAction::class);
            $app->get('/companyuser/{id}', \App\V1\Action\AllCompanyUsersGetterAction::class);
            $app->get('/user/{id}', \App\V1\Action\UserGetterAction::class);
            $app->get('/products/{id}', \App\V1\Action\AllProductsGetterAction::class);
            $app->get('/product/{id}', \App\V1\Action\ProductGetterAction::class);
            $app->get('/sku', \App\V1\Action\AllSkusGetterAction::class);
            $app->get('/sku/{id}', \App\V1\Action\SkuGetterAction::class);
            $app->post('/createsku',  \App\V1\Action\SkuCreateAction::class);
            $app->post('/createservice',  \App\V1\Action\ServiceCreateAction::class);
            $app->post('/createcompanyservice',  \App\V1\Action\CompanyServiceCreatorAction::class);
            $app->post('/createproduct',  \App\V1\Action\ProductCreateAction::class);
            $app->post('/createexpense',  \App\V1\Action\CreateExpenseEntryAction::class);
            $app->post('/expense',  \App\V1\Action\CreateExpenseAction::class);
            $app->get('/expense',  \App\V1\Action\AllExpensesGetterAction::class);
            $app->get('/companyexpenses/{id}',  \App\V1\Action\AllCustomerExpensesGetterAction::class);
            $app->post('/createcompany', \App\V1\Action\CreateCompanyAction::class);//create company
            $app->get('/company', \App\V1\Action\AllCompaniesGetterAction::class);
            $app->get('/company/{id}', \App\V1\Action\CompanyGetterAction::class);
            $app->post('/editcompany', \App\V1\Action\CompanyEditAction::class);
            $app->get('/suppliers/{id}', \App\V1\Action\AllSuppliersGetterAction::class);
            $app->get('/supplier/{id}', \App\V1\Action\SupplierGetterAction::class);
            $app->get('/customers/{id}', \App\V1\Action\AllCustomersGetterAction::class);
            $app->get('/service', \App\V1\Action\AllServicesGetterAction::class);
            $app->get('/companyservice/{id}', \App\V1\Action\AllCompanyServicesGetterAction::class);
            $app->get('/service/{id}', \App\V1\Action\ServiceGetterAction::class);
            $app->get('/customer/{id}', \App\V1\Action\CustomerGetterAction::class);
            $app->get('/accperiod', \App\V1\Action\AllPeriodsGetterAction::class);
            $app->post('/editaccperiod', \App\V1\Action\AccountingPeriodEditAction::class);
            $app->post('/editproduct', \App\V1\Action\ProductEditAction::class);
            $app->post('/editcustomer', \App\V1\Action\CustomerEditAction::class);
            $app->post('/editservice', \App\V1\Action\ServiceEditAction::class);
            $app->post('/editsku', \App\V1\Action\SkuEditAction::class);
            $app->post('/editexpense', \App\V1\Action\ExpenseEditAction::class);
            $app->post('/editsupplier', \App\V1\Action\SupplierEditAction::class);
            $app->get('/accperiod/{id}', \App\V1\Action\AccountingPeriodGetterAction::class);
            $app->post('/createsupplier', \App\V1\Action\CreateSupplierAction::class);//create supplier
            $app->post('/createcustomer', \App\V1\Action\CreateCustomerAction::class);//create customer
            $app->post('/createaccperiod', \App\V1\Action\AccountingPeriodCreateAction::class);//create acc period
            $app->post('/setaccperiod', \App\V1\Action\AccountingPeriodSetAction::class);//set acc period
            $app->delete('/deleteperiod/{id}',  \App\V1\Action\AccountingPeriodDeleteAction::class);
            $app->delete('/deleteproduct/{id}',  \App\V1\Action\ProductDeleteAction::class);
            $app->delete('/deleteservice/{id}',  \App\V1\Action\ServiceDeleteAction::class);
            $app->delete('/deletesku/{id}',  \App\V1\Action\SkuDeleteAction::class);
            $app->delete('/deleteuser/{id}',  \App\V1\Action\UserDeleteAction::class);
            $app->delete('/deletecompany/{id}',  \App\V1\Action\CompanyDeleteAction::class);
            $app->delete('/deletecompanyservice/{id}',  \App\V1\Action\CustomerServiceDeleteAction::class);
  });
    // $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    //     throw new HttpNotFoundException($request);
    // });
};
