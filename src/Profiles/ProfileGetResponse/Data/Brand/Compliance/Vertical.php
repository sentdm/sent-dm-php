<?php

declare(strict_types=1);

namespace SentDm\Profiles\ProfileGetResponse\Data\Brand\Compliance;

enum Vertical: string
{
    case PROFESSIONAL = 'PROFESSIONAL';

    case REAL_ESTATE = 'REAL_ESTATE';

    case HEALTHCARE = 'HEALTHCARE';

    case HUMAN_RESOURCES = 'HUMAN_RESOURCES';

    case ENERGY = 'ENERGY';

    case ENTERTAINMENT = 'ENTERTAINMENT';

    case RETAIL = 'RETAIL';

    case TRANSPORTATION = 'TRANSPORTATION';

    case AGRICULTURE = 'AGRICULTURE';

    case INSURANCE = 'INSURANCE';

    case POSTAL = 'POSTAL';

    case EDUCATION = 'EDUCATION';

    case HOSPITALITY = 'HOSPITALITY';

    case FINANCIAL = 'FINANCIAL';

    case POLITICAL = 'POLITICAL';

    case GAMBLING = 'GAMBLING';

    case LEGAL = 'LEGAL';

    case CONSTRUCTION = 'CONSTRUCTION';

    case NGO = 'NGO';

    case MANUFACTURING = 'MANUFACTURING';

    case GOVERNMENT = 'GOVERNMENT';

    case TECHNOLOGY = 'TECHNOLOGY';

    case COMMUNICATION = 'COMMUNICATION';
}
