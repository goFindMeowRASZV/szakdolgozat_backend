<?php

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

/* public function testAPostResponse() : void
{
    $response = $this->post('/users', ['name' => 'Amy']);
    $response->assertStatus(201);
}
 */