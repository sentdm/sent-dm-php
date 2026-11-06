<?php

declare(strict_types=1);

namespace SentDm\Channels\SMS\SMSCreateParams;

/**
 * Sender type. Decides the provisioning flow and what compliance is asked for.
 *
 * [Required] so the published document says so. The validator has always demanded it, but
 * requiredness reached the schema by matching a rule to a property name — which works for country,
 * whose wire name is its camel-cased C# name, and silently does not for number_type. A client
 * generating a request from our OpenAPI therefore sent what the document called sufficient and was
 * answered 400.
 */
enum NumberType: string
{
    case LOCAL = 'LOCAL';

    case TOLL_FREE = 'TOLL_FREE';

    case SHORT_CODE = 'SHORT_CODE';

    case ALPHANUMERIC = 'ALPHANUMERIC';

    case TEN_DLC = 'TEN_DLC';

    case MOBILE = 'MOBILE';

    case _10_DLC = '10DLC';
}
