<?php
/**
 * OAuthApiTest
 * PHP version 5
 *
 * @category Class
 * @package  Aspose\Cells\Cloud
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Web API Swagger specification
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 1.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.3.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Please update the test case below to test the endpoint.
 */

namespace Aspose\Cells\Cloud;

require_once('vendor\autoload.php');
require_once('vendor\autoload.php');
require_once('test\Api\CellsApiTestBase.php');
use \Aspose\Cells\Cloud\Configuration;
use \Aspose\Cells\Cloud\ApiException;
use \Aspose\Cells\Cloud\ObjectSerializer;
use \Aspose\Cells\Cloud\CellsApiTestBase;
use \Aspose\Cells\Cloud\Api\CellsApi;
use \Aspose\Cells\Cloud\Model\ColumnsResponse;

use \Aspose\Cells\Cloud\Model\MatchConditionRequest;
use \Aspose\Cells\Cloud\Model\Style;
use \Aspose\Cells\Cloud\Model\BatchConvertRequest;
use PHPUnit\Framework\TestCase;

/**
 * OAuthApiTest Class Doc Comment
 *
 * @category Class
 * @package  Aspose\Cells\Cloud
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class CellsBatchApiTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
        $this->instance = CellsApiTestBase::getInstance();
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass()
    {
    }

    public function testCellsBatchConvertApiTest()
    {

        $batchfilesfolder = 'BatchFiles';
        CellsApiTestBase::ready(  $this->instance,'Book1.xlsx' ,$batchfilesfolder);
        CellsApiTestBase::ready(  $this->instance,'myDocument.xlsx' ,$batchfilesfolder);
        CellsApiTestBase::ready(  $this->instance,'datasource.xlsx' ,$batchfilesfolder);
        $batchConvertRequest = new BatchConvertRequest();
        $batchConvertRequest->setSourceFolder($batchfilesfolder);
        $batchConvertRequest->setFormat('PDF');
        $match_condition = new MatchConditionRequest();
        $match_condition->setFullMatchConditions( ["Book1.xlsx","myDocument.xlsx"]);
        $batchConvertRequest->setMatchCondition($match_condition);
        $result = $this->instance->postBatchConvert( $batchConvertRequest);
        // $contents = $result->fread($result->getSize());
        $this->assertGreaterThan(6000, $result->getSize(), "convert files error.");
    }
}
