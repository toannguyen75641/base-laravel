<?php

namespace App\Imports;

use App\Constants\BusinessUserConstant;
use App\Constants\OfficeConstant;
use App\Constants\RegionConstant;
use App\Constants\DepartmentConstant;
use App\Constants\SalesPersonConstant;
use App\Services\Import;
use App\Helpers\StringHelper;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BusinessUserImport extends Import
{
    protected $businessUserRepository;
    protected $officeRepository;
    protected $regionRepository;
    protected $departmentRepository;
    protected $salesPersonRepository;
    protected $listAuthorityType = [
        BusinessUserConstant::INPUT_OFFICES_ID => null,
        BusinessUserConstant::INPUT_REGIONS_ID => null,
        BusinessUserConstant::INPUT_DEPARTMENTS_ID => null,
        BusinessUserConstant::INPUT_SALES_PERSONS_ID => null
    ];

    public function __construct(
        $businessUserRepository, 
        $officeRepository, 
        $regionRepository,
        $departmentRepository,
        $salesPersonRepository
    ) 
    {
        $this->businessUserRepository = $businessUserRepository;
        $this->officeRepository = $officeRepository;
        $this->regionRepository = $regionRepository;
        $this->departmentRepository = $departmentRepository;
        $this->salesPersonRepository = $salesPersonRepository;
    }
    /**
    * @param array $row
    *
    */
    public function model(array $row)
    {
        if(!empty($row[BusinessUserConstant::INPUT_DELETE_AT])) {
            $date = date_create($row[BusinessUserConstant::INPUT_DELETE_AT]);
            $date = date_format($date, DATE_TIME_FORMAT_HIS);
        }
        $data = [
            BusinessUserConstant::INPUT_USER_ID => $row[BusinessUserConstant::INPUT_USER_ID],
            BusinessUserConstant::INPUT_AUTHORITY => array_search($row[BusinessUserConstant::INPUT_AUTHORITY], BusinessUserConstant::AUTHORITY),
            BusinessUserConstant::INPUT_NAME => $row[BusinessUserConstant::INPUT_NAME],
            BusinessUserConstant::INPUT_OFFICES_ID => $this->checkAuthorityType($this->listAuthorityType[BusinessUserConstant::INPUT_OFFICES_ID]),
            BusinessUserConstant::INPUT_REGIONS_ID => $this->checkAuthorityType($this->listAuthorityType[BusinessUserConstant::INPUT_REGIONS_ID]),
            BusinessUserConstant::INPUT_DEPARTMENTS_ID => $this->checkAuthorityType($this->listAuthorityType[BusinessUserConstant::INPUT_DEPARTMENTS_ID]),
            BusinessUserConstant::INPUT_SALES_PERSONS_ID => $this->checkAuthorityType($this->listAuthorityType[BusinessUserConstant::INPUT_SALES_PERSONS_ID]),

            BusinessUserConstant::INPUT_STATUS => array_search($row[BusinessUserConstant::INPUT_STATUS] ,BusinessUserConstant::STATUS),
            BusinessUserConstant::INPUT_DELETE_AT => isset($date) ? $date : null
        ];

        $businessUser = $this->businessUserRepository->getDetail($row[FIELD_ID], SELECT_ALL, true);
        if(!empty($businessUser)) {
            if(!empty($row[BusinessUserConstant::INPUT_PASUWADO])) {
                $data[BusinessUserConstant::INPUT_PASUWADO] = StringHelper::hash($row[BusinessUserConstant::INPUT_PASUWADO]);
            }
            return $this->businessUserRepository->update($businessUser, $data);
        }
        $data[BusinessUserConstant::INPUT_PASUWADO] = StringHelper::hash($row[BusinessUserConstant::INPUT_PASUWADO]);
        return $this->businessUserRepository->create($data);
    }

    /**
     * Check authority type.
     * 
     * @param data
     * 
     * @return mixed
     */
    private function checkAuthorityType($data)
    {
        return $data ? $data->id : null;
    }

    /**
    * @return array
    */
    public function rules(): array
    {
        $authorityOffice = BusinessUserConstant::AUTHORITY[BusinessUserConstant::AUTHORITY_OFFICE];
        $authorityRegion = BusinessUserConstant::AUTHORITY[BusinessUserConstant::AUTHORITY_REGION];
        $authorityDepartment = BusinessUserConstant::AUTHORITY[BusinessUserConstant::AUTHORITY_DEPARTMENT];
        $authoritySalesPerson = BusinessUserConstant::AUTHORITY[BusinessUserConstant::AUTHORITY_SALES_PERSON];
        return [
            '*.'.BusinessUserConstant::INPUT_AUTHORITY => 'required',
            '*.'.BusinessUserConstant::INPUT_USER_ID => [
                'required',
                'min:3',
                'max:30',
                'alpha_num'
            ],
            '*.'.BusinessUserConstant::INPUT_NAME => 'required|min:1|max:50',
            '*.'.BusinessUserConstant::INPUT_STATUS => 'required',
            '*.'.BusinessUserConstant::INPUT_OFFICES_ID => [
                VALIDATION_REQUIRED_IF . ':*.' . BusinessUserConstant::INPUT_AUTHORITY .
                    ",{$authorityOffice},{$authorityRegion},{$authorityDepartment},{$authoritySalesPerson}"
            ],
            '*.'.BusinessUserConstant::INPUT_REGIONS_ID => [
                VALIDATION_REQUIRED_IF . ':*.' . BusinessUserConstant::INPUT_AUTHORITY .
                    ",{$authorityRegion},{$authorityDepartment},{$authoritySalesPerson}"
            ],
            '*.'.BusinessUserConstant::INPUT_DEPARTMENTS_ID => [
                VALIDATION_REQUIRED_IF . ':*.' . BusinessUserConstant::INPUT_AUTHORITY .
                    ",{$authorityDepartment},{$authoritySalesPerson}"
            ],
            '*.'.BusinessUserConstant::INPUT_SALES_PERSONS_ID => [
                VALIDATION_REQUIRED_IF . ':*.' . BusinessUserConstant::INPUT_AUTHORITY . ",{$authoritySalesPerson}"
            ],
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            BusinessUserConstant::INPUT_OFFICES_ID.'.'.VALIDATION_REQUIRED_IF => __('validation.required'),
            BusinessUserConstant::INPUT_REGIONS_ID.'.'.VALIDATION_REQUIRED_IF => __('validation.required'),
            BusinessUserConstant::INPUT_DEPARTMENTS_ID.'.'.VALIDATION_REQUIRED_IF => __('validation.required'),
            BusinessUserConstant::INPUT_SALES_PERSONS_ID.'.'.VALIDATION_REQUIRED_IF => __('validation.required'),
            BusinessUserConstant::INPUT_USER_ID . '.alpha_num' => __('validation.custom.kddi.user.user_id.alpha_num'),
            BusinessUserConstant::INPUT_USER_ID . '.min' => __('validation.custom.kddi.user.user_id.min'),
            BusinessUserConstant::INPUT_USER_ID . '.max' => __('validation.custom.kddi.user.user_id.max'),
            BusinessUserConstant::INPUT_NAME . '.min' => __('validation.custom.kddi.user.name.min'),
            BusinessUserConstant::INPUT_NAME . '.max' => __('validation.custom.kddi.user.name.max'),
            BusinessUserConstant::INPUT_PASUWADO . '.min' => __('validation.custom.kddi.user.password.min'),
            BusinessUserConstant::INPUT_PASUWADO . '.regex' => __('validation.custom.kddi.user.password.regex')
        ];
    }
    
    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return BusinessUserConstant::CSV_HEADER;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(!empty($validator->getData())) {
                $data = array_values($validator->getData())[0];
                $row = array_keys($validator->getData())[0];
                $this->listAuthorityType[BusinessUserConstant::INPUT_OFFICES_ID] = $this->officeRepository->getByCondition([
                    OfficeConstant::INPUT_NAME => $data[BusinessUserConstant::INPUT_OFFICES_ID]
                ])->first();
                $this->listAuthorityType[BusinessUserConstant::INPUT_REGIONS_ID] = $this->regionRepository->getByCondition([
                    RegionConstant::INPUT_NAME => $data[BusinessUserConstant::INPUT_REGIONS_ID]
                ])->first();
                $this->listAuthorityType[BusinessUserConstant::INPUT_DEPARTMENTS_ID] = $this->departmentRepository->getByCondition([
                    DepartmentConstant::INPUT_NAME => $data[BusinessUserConstant::INPUT_DEPARTMENTS_ID]
                ])->first();
                $this->listAuthorityType[BusinessUserConstant::INPUT_SALES_PERSONS_ID] = $this->salesPersonRepository->getByCondition([
                    SalesPersonConstant::INPUT_NAME => $data[BusinessUserConstant::INPUT_SALES_PERSONS_ID]
                ])->first();

                #region check authority is exist
                $validator = $this->checkExistValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_AUTHORITY,
                    $data[BusinessUserConstant::INPUT_AUTHORITY],
                    BusinessUserConstant::AUTHORITY,
                    BusinessUserConstant::AUTHORITY_HEADER
                );
                #endregion

                #region check status is exist
                $validator = $this->checkExistValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_STATUS,
                    $data[BusinessUserConstant::INPUT_STATUS],
                    BusinessUserConstant::STATUS,
                    BusinessUserConstant::STATUS_HEADER
                );
                #endregion

                #region check parent validation
                $validator = $this->checkParentValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_REGIONS_ID,
                    $data[BusinessUserConstant::INPUT_REGIONS_ID],
                    isset($this->listAuthorityType[BusinessUserConstant::INPUT_REGIONS_ID]->offices_id) ?? $this->listAuthorityType[BusinessUserConstant::INPUT_REGIONS_ID]->offices_id,
                    isset($this->listAuthorityType[BusinessUserConstant::INPUT_OFFICES_ID]->id) ?? $this->listAuthorityType[BusinessUserConstant::INPUT_OFFICES_ID]->id,
                    BusinessUserConstant::REGIONS_HEADER
                );
                $validator = $this->checkParentValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_DEPARTMENTS_ID,
                    $data[BusinessUserConstant::INPUT_DEPARTMENTS_ID],
                    isset($this->listAuthorityType[BusinessUserConstant::INPUT_DEPARTMENTS_ID]->regions_id) ?? $this->listAuthorityType[BusinessUserConstant::INPUT_DEPARTMENTS_ID]->regions_id,
                    isset($this->listAuthorityType[BusinessUserConstant::INPUT_REGIONS_ID]->id) ?? $this->listAuthorityType[BusinessUserConstant::INPUT_REGIONS_ID]->id,
                    BusinessUserConstant::DEPARTMENTS_HEADER
                );
                $validator = $this->checkParentValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_SALES_PERSONS_ID,
                    $data[BusinessUserConstant::INPUT_SALES_PERSONS_ID],
                    isset($this->listAuthorityType[BusinessUserConstant::INPUT_SALES_PERSONS_ID]->departments_id) ?? $this->listAuthorityType[BusinessUserConstant::INPUT_SALES_PERSONS_ID]->departments_id,
                    isset($this->listAuthorityType[BusinessUserConstant::INPUT_DEPARTMENTS_ID]->id) ?? $this->listAuthorityType[BusinessUserConstant::INPUT_DEPARTMENTS_ID]->id,
                    BusinessUserConstant::SALES_PERSONS_HEADER
                );
                #endregion

                #region check authority validation
                $validator = $this->checkAuthorityValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_OFFICES_ID,
                    $data[BusinessUserConstant::INPUT_OFFICES_ID],
                    array_search($data[BusinessUserConstant::INPUT_AUTHORITY], BusinessUserConstant::AUTHORITY),
                    [],
                    BusinessUserConstant::OFFICES_HEADER
                );
                $validator = $this->checkAuthorityValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_REGIONS_ID,
                    $data[BusinessUserConstant::INPUT_REGIONS_ID],
                    array_search($data[BusinessUserConstant::INPUT_AUTHORITY], BusinessUserConstant::AUTHORITY),
                    [
                        BusinessUserConstant::AUTHORITY_OFFICE
                    ],
                    BusinessUserConstant::REGIONS_HEADER
                );
                $validator = $this->checkAuthorityValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_DEPARTMENTS_ID,
                    $data[BusinessUserConstant::INPUT_DEPARTMENTS_ID],
                    array_search($data[BusinessUserConstant::INPUT_AUTHORITY], BusinessUserConstant::AUTHORITY),
                    [
                        BusinessUserConstant::AUTHORITY_OFFICE,
                        BusinessUserConstant::AUTHORITY_REGION
                    ],
                    BusinessUserConstant::DEPARTMENTS_HEADER
                );
                $validator = $this->checkAuthorityValidation(
                    $validator,
                    $row,
                    BusinessUserConstant::INPUT_SALES_PERSONS_ID,
                    $data[BusinessUserConstant::INPUT_SALES_PERSONS_ID],
                    array_search($data[BusinessUserConstant::INPUT_AUTHORITY], BusinessUserConstant::AUTHORITY),
                    [
                        BusinessUserConstant::AUTHORITY_OFFICE,
                        BusinessUserConstant::AUTHORITY_REGION,
                        BusinessUserConstant::AUTHORITY_DEPARTMENT,
                    ],
                    BusinessUserConstant::SALES_PERSONS_HEADER
                );
                #endregion

                // check if edit
                if (isset($data[FIELD_ID])) {
                    $businessUser = $this->businessUserRepository->getDetail($data[FIELD_ID], SELECT_ALL, true);
                    // check exist id
                    if (empty($businessUser)) {
                        $validator->errors()->add($row.'.'.FIELD_ID, __('validation.not_exist', ['attribute' => BusinessUserConstant::ID_HEADER]));
                    }
                    else {
                        $validator = $this->checkPasswordValidation(
                            $validator,
                            $row,
                            BusinessUserConstant::INPUT_PASUWADO,
                            trim($data[BusinessUserConstant::INPUT_PASUWADO]),
                            BusinessUserConstant::PASUWADO_HEADER,
                            $data[FIELD_ID]
                        );
                        $businessUserByUserId = $this->businessUserRepository->getByCondition([BusinessUserConstant::INPUT_USER_ID => $data[BusinessUserConstant::INPUT_USER_ID]])->first();
                        // check unique user_id
                        $validator = $this->checkUniqueValidation(
                            $validator,
                            $row,
                            BusinessUserConstant::INPUT_USER_ID,
                            $businessUserByUserId,
                            BusinessUserConstant::USER_ID_HEADER,
                            $data[FIELD_ID]
                        );
                    }
                }
                else {
                    // or create
                    $businessUser = $this->businessUserRepository->getByCondition([BusinessUserConstant::INPUT_USER_ID => $data[BusinessUserConstant::INPUT_USER_ID]])->first();
                    // check unique user_id
                    $validator = $this->checkUniqueValidation(
                        $validator,
                        $row,
                        BusinessUserConstant::INPUT_USER_ID,
                        $businessUser,
                        BusinessUserConstant::USER_ID_HEADER
                    );
                    $validator = $this->checkPasswordValidation(
                        $validator,
                        $row,
                        BusinessUserConstant::INPUT_PASUWADO,
                        trim($data[BusinessUserConstant::INPUT_PASUWADO]),
                        BusinessUserConstant::PASUWADO_HEADER
                    );
                }
            }
            return $validator;
        });
    }

    /**
     * Check unique validate.
     *
     * @param validator
     * @param row
     * @param column
     * @param data
     * @param heading
     * @param id
     *
     * @return mixed
     */
    private function checkUniqueValidation($validator, $row, $column, $data, $heading, $id = null)
    {
        if (!empty($data) && (!$id || ($id && $data->id != $id))) {
            $validator->errors()->add($row.'.'.$column, __('validation.unique', ['attribute' => $heading]));
        }

        return $validator;
    }

    /**
     * Check validation of parent and child field.
     * 
     * @param validator
     * @param row
     * @param column
     * @param value
     * @param childId
     * @param parentId
     * @param heading
     * 
     * @return mixed
     */
    private function checkParentValidation($validator, $row, $column, $value, $childId, $parentId, $heading)
    {
        if (!empty($value) && $childId != $parentId) {
            $validator->errors()->add($row.'.'.$column, __('validation.not_exist', ['attribute' => $heading]));
        }

        return $validator;
    }

    /**
     * Check validation of authority field.
     * 
     * @param validator
     * @param row
     * @param column
     * @param value
     * @param authority
     * @param listAuthority
     * @param heading
     * 
     * @return mixed
     */
    private function checkAuthorityValidation($validator, $row, $column, $value, $authority, $listAuthority, $heading)
    {
        if (
            !empty($value) && (in_array($authority, $listAuthority) || empty($this->listAuthorityType[$column]) && !in_array($authority, $listAuthority))
        ) {
            $validator->errors()->add($row.'.'.$column, __('validation.not_exist', ['attribute' => $heading]));
        }

        return $validator;
    }

    /** 
     * Check password validation.
     * 
     * @param validator
     * @param row
     * @param column
     * @param password
     * @param heading
     * @param id
     * 
     * @return mixed
     */
    private function checkPasswordValidation($validator, $row, $column, $password, $heading, $id = null)
    {
        if (!empty($password)) {
            $regex = "/^(?=.*[a-zA-Z])(?=.*\d).+$/";
            if (strlen($password) < 8 || !preg_match($regex, $password)) {
                $validator->errors()->add($row.'.'.$column, __('validation.custom.kddi.user.password.regex'));
            }
        } elseif (!$id) {
            $validator->errors()->add($row.'.'.$column, __('validation.required', ['attribute' => $heading]));
        }

        return $validator;
    }

    /** 
     * Check exist validation.
     * 
     * @param validator
     * @param row
     * @param column
     * @param value
     * @param list
     * @param heading
     * 
     * @return mixed
     */
    private function checkExistValidation($validator, $row, $column, $value, $list, $heading)
    {
        if(!empty($value) && array_search($value, $list) === false) {
            $validator->errors()->add($row.'.'.$column, __('validation.not_exist', ['attribute' => $heading]));
        }

        return $validator;
    }
}
