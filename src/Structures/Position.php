<?php

namespace Briedis\Breezy\Structures;

class Position
{
    const STATE_DRAFT = 'draft';
    const STATE_CLOSED = 'closed';
    const STATE_PUBLISHED = 'published';
    const STATE_ARCHIVED = 'archived';
    const STATE_PENDING = 'pending';

    const FORM_REQUIRED = 'required';
    const FORM_OPTIONAL = 'optional';
    const FORM_DISABLED = 'disabled';

    const CANDIDATE_ALL = 'all';
    const CANDIDATE_NONE = 'none';
    const CANDIDATE_UNLISTED = 'unlisted';
    const CANDIDATE_INTERNAL = 'internal';

    const TYPE_FULLTIME = 'fullTime';
    const TYPE_PARTTIME = 'partTime';
    const TYPE_CONTRACT = 'contract';
    const TYPE_TEMPORARY = 'temporary';
    const TYPE_OTHER = 'other';

    const CATEGORY_SOFTWARE = 'software';
    const CATEGORY_DESIGN = 'design';
    const CATEGORY_PRODUCT = 'product';
    const CATEGORY_SYSADMIN = 'sysadmin';
    const CATEGORY_DEVOPS = 'devops';
    const CATEGORY_FINANCE = 'finance';
    const CATEGORY_CUSTSERV = 'custserv';
    const CATEGORY_SALES = 'sales';
    const CATEGORY_MARKETING = 'marketing';
    const CATEGORY_PR = 'pr';
    const CATEGORY_DESIGN_NOT_INTERACTIVE = 'design-not-interactive';
    const CATEGORY_HR = 'hr';
    const CATEGORY_MANAGEMENT = 'management';
    const CATEGORY_OPERATIONS = 'operations';
    const CATEGORY_OTHER = 'other';

    const EDUCATION_UNSPECIFIED = 'unspecified';
    const EDUCATION_HIGH_SCHOOL = 'high-school';
    const EDUCATION_CERTIFICATION = 'certification';
    const EDUCATION_VOCATIONAL = 'vocational';
    const EDUCATION_ASSOCIATE_DEGREE = 'associate-degree';
    const EDUCATION_BACHELORS_DEGREE = 'bachelors-degree';
    const EDUCATION_MASTERS_DEGREE = 'masters-degree';
    const EDUCATION_DOCTORATE = 'doctorate';
    const EDUCATION_PROFESSIONAL = 'professional';
    const EDUCATION_SOME_COLLEGE = 'some-college';
    const EDUCATION_VOCATIONAL_DIPLOMA = 'vocational-diploma';
    const EDUCATION_VOCATIONAL_DEGREE = 'vocational-degree';
    const EDUCATION_SOME_HIGH_SCHOOL = 'some-high-school';

    const EXPERIENCE_NA = 'na';
    const EXPERIENCE_INTERNSHIP = 'internship';
    const EXPERIENCE_ENTRY_LEVEL = 'entry-level';
    const EXPERIENCE_ASSOCIATE = 'associate';
    const EXPERIENCE_MID_LEVEL = 'mid-level';
    const EXPERIENCE_SENIOR_LEVEL = 'senior-level';
    const EXPERIENCE_EXECUTIVE = 'executive';

    private $_id;
    private $type;
    private $state;
    private $name;
    private $friendly_id;
    private $experience;
    private $location;
    private $education;
    private $department;
    private $requisition_id;
    private $description;
    private $category;
    private $application_form;
    private $creator_id;
    private $creation_date;
    private $updated_date;
    private $questionnaire_id;
    private $scorecard_id;
    private $all_users;
    private $all_admins;
    private $pipeline_id;
    private $candidate_type;
    private $custom_attributes;

    public static function fromResponse(array $rawPosition)
    {
        $_id = $rawPosition['_id'];
        $type = $rawPosition['type'];
        $state = $rawPosition['state'];
        $name = $rawPosition['name'];
        $friendly_id = $rawPosition['friendly_id'];
        $experience = $rawPosition['experience'];
        $location = $rawPosition['location'];
        $education = $rawPosition['education'];
        $department = $rawPosition['department'];
        $requisition_id = $rawPosition['requisition_id'];
        $description = $rawPosition['description'];
        $category = $rawPosition['category'];
        $application_form = $rawPosition['application_form'];
        $creator_id = $rawPosition['creator_id'];
        $creation_date = $rawPosition['creation_date'];
        $updated_date = $rawPosition['updated_date'];
        $questionnaire_id = $rawPosition['questionnaire_id'];
        $scorecard_id = $rawPosition['scorecard_id'];
        $all_users = $rawPosition['all_users'];
        $all_admins = $rawPosition['all_admins'];
        $pipeline_id = $rawPosition['pipeline_id'];
        $candidate_type = $rawPosition['candidate_type'];
        $custom_attributes = $rawPosition['custom_attributes'];

        return new Position(
            $_id,
            $type,
            $state,
            $name,
            $friendly_id,
            $experience,
            $location,
            $education,
            $department,
            $requisition_id,
            $description,
            $category,
            $application_form,
            $creator_id,
            $creation_date,
            $updated_date,
            $questionnaire_id,
            $scorecard_id,
            $all_users,
            $all_admins,
            $pipeline_id,
            $candidate_type,
            $custom_attributes
        );
    }

    public function __construct(
        $_id,
        $type,
        $state,
        $name,
        $friendly_id,
        $experience,
        $location,
        $education,
        $department,
        $requisition_id,
        $description,
        $category,
        $application_form,
        $creator_id,
        $creation_date,
        $updated_date,
        $questionnaire_id,
        $scorecard_id,
        $all_users,
        $all_admins,
        $pipeline_id,
        $candidate_type,
        $custom_attributes
    ) {
        $this->_id = $_id;
        $this->type = $type;
        $this->state = $state;
        $this->name = $name;
        $this->friendly_id = $friendly_id;
        $this->experience = $experience;
        $this->location = $location;
        $this->education = $education;
        $this->department = $department;
        $this->requisition_id = $requisition_id;
        $this->description = $description;
        $this->category = $category;
        $this->application_form = $application_form;
        $this->creator_id = $creator_id;
        $this->creation_date = $creation_date;
        $this->updated_date = $updated_date;
        $this->questionnaire_id = $questionnaire_id;
        $this->scorecard_id = $scorecard_id;
        $this->all_users = $all_users;
        $this->all_admins = $all_admins;
        $this->pipeline_id = $pipeline_id;
        $this->candidate_type = $candidate_type;
        $this->custom_attributes = $custom_attributes;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->state === self::STATE_PUBLISHED;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getFriendlyId()
    {
        return $this->friendly_id;
    }

    /**
     * @return mixed
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @return mixed
     */
    public function getRequisitionId()
    {
        return $this->requisition_id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getApplicationForm()
    {
        return $this->application_form;
    }

    /**
     * @return mixed
     */
    public function getCreatorId()
    {
        return $this->creator_id;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updated_date;
    }

    /**
     * @return mixed
     */
    public function getQuestionnaireId()
    {
        return $this->questionnaire_id;
    }

    /**
     * @return mixed
     */
    public function getScorecardId()
    {
        return $this->scorecard_id;
    }

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        return $this->all_users;
    }

    /**
     * @return mixed
     */
    public function getAllAdmins()
    {
        return $this->all_admins;
    }

    /**
     * @return mixed
     */
    public function getPipelineId()
    {
        return $this->pipeline_id;
    }

    /**
     * @return mixed
     */
    public function getPositionType()
    {
        return $this->candidate_type;
    }

    /**
     * @return mixed
     */
    public function getCustomAttributes()
    {
        return $this->custom_attributes;
    }
}
