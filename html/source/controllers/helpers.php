<?php

function GetApiPath(string $resource, int $id): string
{
    return sprintf('/%s/%d', ltrim($resource, '/'), $id);
}
