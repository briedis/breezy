<?php


namespace Briedis\Breezy\Structures;


class PositionItem extends BaseItem
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

    /**
     * @var string
     */
    public $id = '';

    /**
     * @var array|string
     */
    public $type = [];

    /**
     * @var string
     */
    public $state = '';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $friendly_id = '';

    /**
     * @var array|string
     */
    public $experience = [];

    /**
     * @var array
     */
    public $location = [];

    /**
     * @var array|string
     */
    public $education = [];

    /**
     * @var string
     */
    public $department = '';

    /**
     * @var string
     */
    public $requisition_id = '';

    /**
     * @var string
     */
    public $description = '';

    /**
     * @var array|string
     */
    public $category = [];

    /**
     * @var array
     */
    public $application_form = [];

    /**
     * @var number
     */
    public $creator_id = null;

    /**
     * @var string
     */
    public $creation_date = '';

    /**
     * @var string
     */
    public $updated_date = '';

    /**
     * @var number
     */
    public $questionnaire_id = null;

    /**
     * @var number
     */
    public $scorecard_id = null;

    /**
     * @var array
     */
    public $all_users = [];

    /**
     * @var array
     */
    public $all_admins = [];

    /**
     * @var number
     */
    public $pipeline_id = null;

    /**
     * @var string
     */
    public $candidate_type = '';


    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->state === self::STATE_PUBLISHED;
    }

    /**
     * @inheritdoc
     */
    public static function fromArray(array $rawPosition)
    {
        $position = new PositionItem;

        $position->rawData = $rawPosition;

        $position->id = $rawPosition['_id'];
        $position->type = $rawPosition['type'];
        $position->state = $rawPosition['state'];
        $position->name = $rawPosition['name'];
        $position->friendly_id = $rawPosition['friendly_id'];
        $position->experience = isset($rawPosition['experience']) ? $rawPosition['experience'] : null;
        $position->location = $rawPosition['location'];
        $position->education = isset($rawPosition['education']) ? $rawPosition['education'] : null;
        $position->department = $rawPosition['department'];
        $position->requisition_id = $rawPosition['requisition_id'];
        $position->description = $rawPosition['description'];
        $position->category = $rawPosition['category'];
        $position->application_form = $rawPosition['application_form'];
        $position->creator_id = $rawPosition['creator_id'];
        $position->creation_date = $rawPosition['creation_date'];
        $position->updated_date = $rawPosition['updated_date'];
        $position->questionnaire_id = isset($rawPosition['questionnaire_id']) ? $rawPosition['questionnaire_id'] : null;
        $position->scorecard_id = isset($rawPosition['scorecard_id']) ? $rawPosition['scorecard_id'] : null;
        $position->all_users = $rawPosition['all_users'];
        $position->all_admins = $rawPosition['all_admins'];
        $position->pipeline_id = isset($rawPosition['pipeline_id']) ? $rawPosition['pipeline_id'] : null;
        $position->candidate_type = $rawPosition['candidate_type'];

        return $position;
    }
}