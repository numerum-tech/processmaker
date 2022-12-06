<?php

namespace ProcessMaker\ImportExport;

abstract class DependentType
{
    const SCRIPTS = 'scripts';

    const CATEGORIES = 'categories';

    const SCREENS = 'screens';

    const NOTIFICATION_SETTINGS = 'process_notification_settings';

    const ENVIRONMENT_VARIABLES = 'environment_variables';

    const SCRIPT_EXECUTORS = 'script_executors';

    const SUB_PROCESSES = 'sub_processes';

    const GROUPS = 'groups';

    const USER_ASSIGNMENT = 'user_assignment';

    const GROUP_ASSIGNMENT = 'group_assignment';
}
