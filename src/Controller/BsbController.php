<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class BsbController extends ApiController
{
    private $queryId = 2224445;
    private $smsId = 987;
    private $mCode = 'ZJJHHZ';

    /**
     * @Route("/bsb")
     */
    public function index()
    {
        $response = new JsonResponse(array('ping' => 'pong'));
        return $response;
    }

    /**
     * @Route("/api_ibank/api/query/insert/{type} methods={"POST"}")
     * @return JsonResponse
     */
    public function insert(int $type)
    {
        if (9 != $type) {
            return new JsonResponse([
                'error' => 'wrong query type'
            ]);
        }

        return new JsonResponse([
            'id' => $this->queryId
        ]);
    }

    /**
     * @Route("/api_ibank/api/queries methods={"POST"}")
     * @return JsonResponse
     */
    public function queries()
    {
        return new JsonResponse([
            "id" => $this->queryId,
            "type" => 9,
            "typeName" => "Платежное поручение в белорусских рублях",
            "dateIn" => 1570010148000,
            "dateInString" => "2019-10-02T12:55:48+03:00",
            "dateOut" => 1570010966000,
            "dateOutString" => "2019-10-02T13:09:26+03:00",
            "lastStatus" => 6,
            "lastStatusName" => "Проведен",
            "answerString" => "ИСПОЛНЕНО БАНКОМ",
            "groupId" => 5,
            "groupName" => "Проведенные Банком",
            "fields" => [
                [
                    "extraIndex" => 0,
                    "extraName" => "Платежное поручение в белорусских рублях",
                    "extraValue" => "9",
                    "extraTag" => "type"
                ],
                [
                    "extraIndex" => 1,
                    "extraName" => "Дата и время создания запроса",
                    "extraValue" => "2019-10-02T12:55:48+03:00",
                    "extraTag" => "dateInString"
                ],
                [
                    "extraIndex" => 2,
                    "extraName" => "Дата и время изменения запроса",
                    "extraValue" => "2019-10-02T13:09:26+03:00",
                    "extraTag" => "dateOutString"
                ],
                [
                    "extraIndex" => 3,
                    "extraName" => "Ответ из банка",
                    "extraValue" => "ИСПОЛНЕНО БАНКОМ",
                    "extraTag" => "answerString"
                ],
                [
                    "extraIndex" => 4,
                    "extraName" => "Дата документа",
                    "extraValue" => "24.09.2019",
                    "extraTag" => "DatePlt"
                ],
                [
                    "extraIndex" => 5,
                    "extraName" => "Номер документа",
                    "extraValue" => "100021",
                    "extraTag" => "N_plt"
                ],
                [
                    "extraIndex" => 6,
                    "extraName" => "Сумма",
                    "extraValue" => "0.01",
                    "extraTag" => "004"
                ],
                [
                    "extraIndex" => 7,
                    "extraName" => "Получатель",
                    "extraValue" => "Juons Puovuls",
                    "extraTag" => "KorName"
                ],
                [
                    "extraIndex" => 8,
                    "extraName" => "Банк получателя",
                    "extraValue" => "ЗАО 'БСБ БАНК'",
                    "extraTag" => "Bank2"
                ],
                [
                    "extraIndex" => 9,
                    "extraName" => "Счёт получателя",
                    "extraValue" => "BY08UNBS31231231231231231231",
                    "extraTag" => "KorAcc"
                ],
                [
                    "extraIndex" => 10,
                    "extraName" => "Назначение",
                    "extraValue" => "PAYMENTORDER19 ID:19/AG:3625/АГ7960655 Juons Puovuls 23098320942093",
                    "extraTag" => "NaznText"
                ]
            ]
        ]);
    }

    /**
     * @Route("/api_ibank/api/queries/mcode methods={"POST"}")
     * @return JsonResponse
     */
    public function getMcode()
    {
        $queryIds = $this->request->get('queryIds');
        if (!$queryIds || !array_key_exists(0, $queryIds)) {
            return new JsonResponse([
                'error' => 'getMcode: No query ids are provided'
            ]);
        }

        if ($this->queryId != $queryIds[0]) {
            return new JsonResponse([
                'error' => 'getMcode: Wrong query id'
            ]);
        }

        return new JsonResponse([
            'smsId' => $this->smsId
        ]);
    }

    /**
     * @Route("/api_ibank/api/queries/sign/sms methods={"POST"}")
     * @return JsonResponse
     */
    public function confirmMcode()
    {
        $smsId = $this->request->get('smsId');
        if (!$smsId) {
            return new JsonResponse([
                'error' => 'No sms id is provided'
            ]);
        }

        if ($this->smsId != $smsId) {
            return new JsonResponse([
                'error' => 'Wrong sms id'
            ]);
        }

        $mCode = $this->request->get('mCode');
        if (!$mCode) {
            return new JsonResponse([
                'error' => 'No mcode is provided'
            ]);
        }

        if ($this->mCode != $mCode) {
            return new JsonResponse([
                'error' => 'Wrong mCode'
            ]);
        }

        return new JsonResponse([
            'messages' => [
                $this->queryId => 'OK'
            ]
        ]);
    }

    /**
     * @Route("/api_ibank/api/queries/{queryId}/send methods={"POST"}")
     * @param int $queryId
     * @return JsonResponse
     */
    public function sendConfirmedStatement(int $queryId)
    {
        if ($this->queryId != $queryId) {
            return new JsonResponse([
                'error' => 'sendConfirmStatement: Wrong query id'
            ]);
        }

        return (new JsonResponse())
            ->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
    }

}
