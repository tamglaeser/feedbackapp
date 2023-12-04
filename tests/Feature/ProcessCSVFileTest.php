<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProcessCSVFileTest extends TestCase
{
    use RefreshDatabase; // This trait resets the database after each test
    /** @test */
    public function it_processes_csv_file_from_url()
    {
        $csvContent = <<<CSV
            Reviews Content,Rating,Start Date,Address,Appartments,Source
            "The app hardly ever works. I have restarted more than 10 times, even reinstalled and still can't view the menu 😏",1,2021-08-17 00:00:00,"801 Silbury Blvd, Milton Keynes MK9 3FL, United Kingdom",Solstice Apartments,Google
            "Very bad housing association. They want your money and that’s all. They don’t care about problems or defects. They allowed to build houses with windows that let the draught passing through and it’s a waste of energy bills. The traffic noise is horrible as well. Very bad experience

            ",1,2021/09/18,"Ferry Ln, London N17 9NF, United Kingdom",Windlass Apartments,Truspilot
            CSV;
        Http::fake([
            'http://feedier-production.s3.eu-west-1.amazonaws.com/*' => Http::response($csvContent, 200),
        ]);

        $this->artisan('csv:process')
            ->expectsOutput('Feedier CSV file processed successfully')
            ->assertExitCode(0);

        $this->assertDatabaseHas('feedback', [
            'review' => "The app hardly ever works. I have restarted more than 10 times, even reinstalled and still can't view the menu 😏",
            'rating' => 1,
            'start_date' => "2021-08-17 00:00:00",
            'address' => "801 Silbury Blvd, Milton Keynes MK9 3FL, United Kingdom",
            'appartments' => "Solstice Apartments",
            'source' => "Google"
        ]);

        $this->assertDatabaseHas('feedback', [
            'review' => "Very bad housing association. They want your money and that’s all. They don’t care about problems or defects. They allowed to build houses with windows that let the draught passing through and it’s a waste of energy bills. The traffic noise is horrible as well. Very bad experience",
            'rating' => 1,
            'start_date' => "2021/09/18",
            'address' => "Ferry Ln, London N17 9NF, United Kingdom",
            'appartments' => "Windlass Apartments",
            'source' => "Truspilot"
        ]);
    }
}
