<?php

function sum($n1, $n2)
{
    return $n1 + $n2;
}

test('sum', function () {
    $result = sum(1, 2);

    expect($result)->toBe(3);
});

it('sum two numbers', function () {
    $result = sum(1, 2);
    expect($result)->toBe(3);
    $this->assertSame(3, $result);
});

it('sum two other numbers', function () {
    $result = sum(1, 2);
    $this->assertSame(3, $result);
});

it('throws exception', function () {
    throw new Exception('Something happened.');
})->throws(Exception::class, 'Something happened.');

it('throws no exceptions', function () {
    $result = 1 + 1;
})->throwsNoExceptions();

it('throws another exception', function () {
    throw new Exception('Something else happened');
})->throws(Exception::class, 'Something else happened');

it('throws no exception', function () {
    $result = 2 + 2;
})->throwsNoExceptions();


//XDEBUG_MODE=coverage ./vendor/bin/pest --coverage