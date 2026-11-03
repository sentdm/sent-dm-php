<?php

declare(strict_types=1);

namespace SentDm\Core;

/**
 * Marks a body param the caller didn't pass, distinct from one they passed as `null`.
 *
 * Every optional body param already defaults to `null`, so a method can't otherwise tell
 * "leave this field alone" from "clear this field" when the API gives the two a different
 * meaning. Use this as the default instead of `null` for such a param, and check for it
 * with `$value instanceof Omit` before building the request body. Same role as the
 * `Omit`/`omit` sentinel the Python SDK already uses for the same problem.
 */
final class Omit
{
}
