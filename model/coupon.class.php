<?php
use Aws\DynamoDb\Exception\DynamoDbException;


class Coupon{

    private $tableName = 'coupons';
    private $key = 'code';
    private $client;

    public function __construct($client){
        $this->client = $client;
    }

    // retrieve all coupons from the table
    public function getAllCoupons() {
        try {
            $result = $this->client->scan([
                'TableName' => $this->tableName,
            ]);
            return $result['Items'];
        } catch (DynamoDbException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // count the number of coupons in the table
    public function countCoupons(){
        try {
            $result = $this->client->scan([
                'TableName' => $this->tableName,
                'Select' => 'COUNT',
                'ReturnConsumedCapacity' => 'NONE',
            ]);
    
            $count = $result['Count'];
            return $count;
        } catch (DynamoDbException $e) {
            echo "An error occurred while accessing the CrunchyPass table: " . $e->getMessage();
            return 0;
        }
    }

    // retrieve a single coupon by ID from the table
    public function getCouponById($id) {
        try {
            $result = $this->client->getItem([
                'TableName' => $this->tableName,
                'Key' => [
                    'n' => [
                        'N' => strval($id),
                    ],
                ],
            ]);
            $item = $result->get('Item');
            return $item;
        } catch (DynamoDbException $e) {
            return ['error' => $e->getMessage()];
        }
    }


    // add a new coupon to the table
    public function addCoupon($owner, $code, $quest, $quest_ans){
        $code = strtoupper($code);
        try{
            // check if coupon code already exists in the database
            $params = [
                'TableName' => $this->tableName,
                'FilterExpression' => '#' . $this->key . ' = :v_' . $this->key,
                'ExpressionAttributeNames' => ['#' . $this->key => $this->key],
                'ExpressionAttributeValues' => [
                    ':v_' . $this->key => ['S' => $code]
                ],
            ];
            $result = $this->client->scan($params);

            // return false if coupon already exists in the database
            $params =[];
            if (count($result['Items']) > 0) {
                return false;
            } else {
                if ($quest === null && $quest_ans === null) { // check if new coupon does not have a custom challenge 
                    $params = [
                        'TableName' => $this->tableName,
                        'Item' => [
                            'n' => [
                                'N' => strval(time())
                            ],
                            'owner' => [
                                'S' => $owner
                            ],
                            'code' => [
                                'S' => $code
                            ]
                        ]
                    
                    ];
                } else {  // extended params for a coupon with custom challenge
                    $params = [
                        'TableName' => $this->tableName,
                        'Item' => [
                            'n' => [
                                'N' => strval(time())
                            ],
                            'owner' => [
                                'S' => $owner
                            ],
                            'code' => [
                                'S' => $code
                            ],
                            'quest' => [
                                'S' => $quest
                            ],
                            'quest_ans' => [
                                'S' => strtolower($quest_ans)
                            ]
                        ]
                    ];
                }
                return $result = $this->client->putItem($params);
            }
        } catch (DynamoDbException $e) {
            return false;
        }
    }

    // update a coupon's claimer in the table
    public function updateCouponClaimer($id, $claimer) {
        try {
            $result = $this->client->updateItem([
                'TableName' => $this->tableName,
                'Key' => [
                    'n' => [
                        'N' => strval($id),
                    ],
                ],
                'UpdateExpression' => 'SET claimer = :claimer',
                'ExpressionAttributeValues' => [
                    ':claimer' => [
                        'S' => strval($claimer),
                    ],
                ],
                'ReturnValues' => 'UPDATED_NEW',
            ]);
            $updatedItem = $result['Attributes'];
            return $updatedItem;
        } catch (DynamoDbException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    // delete an existing coupon from the table
    public function deleteCoupon($id) {
        try {
            $this->client->deleteItem([
                'TableName' => $this->tableName,
                'Key' => [
                    'n' => ['N' => strval($id)],
                ],
            ]);
            return ['success' => 'Employee deleted successfully.'];
        } catch (DynamoDbException $e) {
            return ['error' => $e->getMessage()];
        }
    }

}











