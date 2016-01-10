<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Validator::extend(
    'distinct_sets',
    function ($attribute, $value, $parameters, $validator)
    {
        $teamOne = $value;
        $teamTwo = array_get($validator->getData(), $parameters[0]);
        $mergedArr = array_merge($teamOne, $teamTwo);
        return count($mergedArr) == count(array_unique($mergedArr));
    }
);

Validator::extend(
    'same_size',
    function ($attribute, $value, $parameters, $validator)
    {
        $teamOne = $value;
        $teamTwo = array_get($validator->getData(), $parameters[0]);
        return count($teamOne) == count($teamTwo);
    }
);

Validator::extend(
    'check_even',
    function ($attribute, $value, $parameters, $validator)
    {
        $squad = $value;
        return (count($squad) % 2) === 0;
    }
);