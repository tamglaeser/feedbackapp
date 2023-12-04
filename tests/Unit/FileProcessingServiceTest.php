<?php

namespace Tests\Unit;

use App\Models\Feedback;
use App\Services\FileProcessingService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileProcessingServiceTest extends TestCase
{
    use RefreshDatabase; // This trait resets the database after each test

    /** @test */
    public function it_processes_csv_content_correctly()
    {
        $fileService = new FileProcessingService();

        // Mock CSV content for testing
        $csvContent = "Reviews Content,Rating,Start Date,Address,Appartments,Source\nReview 1,5,2023-01-01,Address 1,Solstice Apartments,Google\nReview 2,4,2023-01-02,Address 2,Kings Dock Mill Liverpool,Truspilot";

        // Call the method to process CSV content
        $fileService->processCSVContent($csvContent);

        $this->assertDatabaseCount('feedback', 2);
        $this->assertDatabaseHas('feedback', [
            'review' => "Review 1",
            'rating' => 5,
            'start_date' => "2023-01-01",
            'address' => "Address 1",
            'appartments' => "Solstice Apartments",
            'source' => "Google"
        ]);
        $this->assertDatabaseHas('feedback', [
            'review' => "Review 2",
            'rating' => 4,
            'start_date' => "2023-01-02",
            'address' => "Address 2",
            'appartments' => "Kings Dock Mill Liverpool",
            'source' => "Truspilot"
        ]);
    }

    /** @test */
    public function it_throws_exception_on_invalid_rating()
    {
        $fileService = new FileProcessingService();

        // Mock CSV content with an invalid rating
        $csvContent = "review,rating,start_date,address,appartments,source\nInvalid Review,0,2023-01-01,Address 1,3,Source 1";

        // Use try-catch to capture the exception thrown by the method
        try {
            $fileService->processCSVContent($csvContent);

            // If an exception is not thrown, fail the test
            $this->fail('Expected Exception was not thrown.');
        } catch (Exception $e) {
            // Assert that the exception message contains the expected string
            $this->assertStringContainsString('Validation failed', $e->getMessage());
        }

        // Ensure that no feedback entries were created due to the invalid rating
        $this->assertEquals(0, Feedback::count());
    }
}
