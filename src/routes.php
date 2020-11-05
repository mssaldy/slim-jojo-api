<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    //getUser
    $app->post("/getUser/{id}", function (Request $request, Response $response, $args){
        $this->logger->info("get user by Id");

        $id = $args["id"];
        $sql = "SELECT * FROM user WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    //getListUser
    $app->post("/getListUser", function (Request $request, Response $response){
        $this->logger->info("Get list user");      

        $sql = "SELECT * FROM user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->logger->info($response->withJson(["status" => "success", "data" => $result], 200));
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    //getCompany
    $app->post("/getCompany/{id}", function (Request $request, Response $response, $args){
        $this->logger->info("User get Data Company by Id");

        $id = $args["id"];
        $sql = "SELECT * FROM company WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    //getListCompany
    $app->post("/getListCompany", function (Request $request, Response $response){
        $this->logger->info("get list company");       

        $sql = "SELECT * FROM company";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->logger->info($response->withJson(["status" => "success", "data" => $result], 200));
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    //getBudgetCompany
    $app->post("/getBudgetCompany/{id}", function (Request $request, Response $response, $args){
        $this->logger->info("/get Budget Company/");

        $id = $args["id"];
        $sql = "SELECT * FROM company_budget WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    //getListBudgetCompany
    $app->post("/getListBudgetCompany", function (Request $request, Response $response){
        $this->logger->info("/get list budget company/");

        $sql = "SELECT * FROM company_budget";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->logger->info($response->withJson(["status" => "success", "data" => $result], 200));
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    //getLogTransaction 
    $app->post("/getLogTransaction", function (Request $request, Response $response){
        $this->logger->info("getLogTransaction");        

        $sql = "SELECT user.first_name, user.account, transaction.type, transaction.date, transaction.amount,company.name, company.address, company_budget.amount 
        FROM company 
        INNER JOIN company_budget ON company.id=company_budget.company_id 
        INNER JOIN user ON user.company_id=company.id 
        INNER JOIN transaction ON user.company_id=transaction.user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->logger->info($response->withJson(["status" => "success", "data" => $result], 200));
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->post("/createUser", function (Request $request, Response $response){
        $this->logger->info("/create user/");

        $new_user = $request->getParsedBody();
    
        $sql = "INSERT INTO user (`first_name`, `last_name`, `email`, `account`, `company_id`) VALUES (:first_name, :last_name, :email, :account, :company_id)";
        $stmt = $this->db->prepare($sql);
    
        $data = [
            ":first_name" => $new_user["first_name"],
            ":last_name" => $new_user["last_name"],
            ":email" => $new_user["email"],
            ":account" => $new_user["account"],
            ":company_id" => $new_user["company_id"]
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->post("/updateUser/{id}", function (Request $request, Response $response, $args){
        $this->logger->info("/update user/");

        $id = $args["id"];
        $new_user = $request->getParsedBody();
        $sql = "UPDATE user SET `first_name`=:first_name,`last_name`=:last_name,`email`=:email,`account`=:account,`company_id`=:company_id WHERE `id`=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id,
            ":first_name" => $new_user["first_name"],
            ":last_name" => $new_user["last_name"],
            ":email" => $new_user["email"],
            ":account" => $new_user["account"],
            ":company_id" => $new_user["company_id"]
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->delete("/deleteUser/{id}", function (Request $request, Response $response, $args){
        $this->logger->info("/delete user/");

        $id = $args["id"];
        $sql = "DELETE FROM user WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    //createCompany
    $app->post("/createCompany", function (Request $request, Response $response){
        $this->logger->info("/create company/");

        $new_company = $request->getParsedBody();
    
        $sql = "INSERT INTO company (`name`, `address`) VALUES (:name, :address)";
        $stmt = $this->db->prepare($sql);
    
        $data = [
            ":name" => $new_company["name"],
            ":address" => $new_company["address"]
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->post("/updateCompany/{id}", function (Request $request, Response $response, $args){
        $this->logger->info("/update company/");
        $id = $args["id"];
        $new_company = $request->getParsedBody();
        $sql = "UPDATE company SET `name`=:name, `address`=:address WHERE `id`=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id,
            ":name" => $new_company["name"],
            ":address" => $new_company["address"]
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->delete("/deleteCompany/{id}", function (Request $request, Response $response, $args){
        $this->logger->info("/delete company/");

        $id = $args["id"];
        $sql = "DELETE FROM company WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":id" => $id
        ];
    
        if($stmt->execute($data))
           return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    // UPDATE company_budget
    // INNER JOIN user ON company_budget.company_id = user.company_id
    // INNER JOIN transaction ON user.id = transaction.user_id
    // SET 
    // company_budget.amount = company_budget.amount + transaction.amount;
    
    $app->post("/reimburse", function (Request $request, Response $response, $args){
        $this->logger->info("/reimburse/");

        $reimburse = $request->getParsedBody();
        $sql = "INSERT INTO transaction (`type`, `user_id`, `amount`, `date`) VALUES (:type, :user_id, :amount, :date)";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":type" => $reimburse["type"],
            ":user_id" => $reimburse["user_id"],
            ":amount" => $reimburse["amount"],
            ":date" => date("Y-m-d H:i:s")
        ];

        // print_r($data[":type"]);
    
        if($stmt->execute($data)){
            if($data[":type"] == 'R') {
                    $sql = "UPDATE company_budget
                    INNER JOIN user ON company_budget.company_id = user.company_id
                    INNER JOIN transaction ON user.id = transaction.user_id
                    SET
                    company_budget.amount = company_budget.amount - transaction.amount"; //WHERE user.company_id=company_budget.company_id
                    $stmt=$this->db->prepare($sql);
                    $stmt->execute($data);
                }
            }
            return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->post("/disburse/", function (Request $request, Response $response, $args){
        $this->logger->info("/disburse/");

        $disburse = $request->getParsedBody();
        $sql = "INSERT INTO transaction (`type`, `user_id`, `amount`, `date`) VALUES (:type, :user_id, :amount, :date)";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":type" => $disburse["type"],
            ":user_id" => $disburse["user_id"],
            ":amount" => $disburse["amount"],
            ":date" => date("Y-m-d H:i:s")
        ];

        if($stmt->execute($data)){
            if($data[":type"] == 'C') {
                    $sql = "UPDATE company_budget
                    INNER JOIN user ON company_budget.company_id = user.company_id
                    INNER JOIN transaction ON user.id = transaction.user_id
                    SET 
                    company_budget.amount = company_budget.amount - transaction.amount";
                    $stmt=$this->db->prepare($sql);
                    $stmt->execute($data);
                }
            }
            return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->post("/close/", function (Request $request, Response $response, $args){
        $this->logger->info("/Close/");
        $new_close = $request->getParsedBody();
        $sql = "INSERT INTO transaction (`type`, `user_id`, `amount`, `date`) VALUES (:type, :user_id, :amount, :date)";
        $stmt = $this->db->prepare($sql);
        
        $data = [
            ":type" => $new_close["type"],
            ":user_id" => $new_close["user_id"],
            ":amount" => $new_close["amount"],
            ":date" => date("Y-m-d H:i:s")
        ];

        if($stmt->execute($data)){
            if($data[":type"] == 'S') {
                    $sql = "UPDATE company_budget
                    INNER JOIN user ON company_budget.company_id = user.company_id
                    INNER JOIN transaction ON user.id = transaction.user_id
                    SET 
                    company_budget.amount = company_budget.amount + transaction.amount";
                    $stmt=$this->db->prepare($sql);
                    $stmt->execute($data);
                }
            }
            return $response->withJson(["status" => "success", "data" => "1"], 200);
        
        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });
    
};
