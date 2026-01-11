## Architecture

```
app/
  Enums/
    CallStage.php                             # Differentiating Call Stages
  Http/
    Controllers/Api/
      WorkTaskResolutionReportController.php  # Thin controller with Request Validation, Resource Formatting, and Business Logic in Service
    Requests/Api/
      WorkTaskResolutionReportRequest.php     # Input validation making sure neccesary information is present
    Resources/
      WorkTaskResolutionReportResource.php    # Resource formatting the output
  Models/
    Call.php
    ResolutionType.php
    WorkTask.php
  Services/
    WorkTaskResolutionReportService.php       # Business logic
```

## Design Decisions

1. **Service Layer**: Business logic is encapsulated in `WorkTaskResolutionReportService` to keep the controller thin and logic testable/reusable.

2. **Form Request**: Validation is handled by a dedicated Form Request class for clean separation of concerns.

3. **API Resources**: Used `JsonResource` to format the response, making it easy to modify the output structure without changing the service layer.

4. **Efficient Query**: Uses models to load the correct data

5. **Inclusive Date Range**: The date filter includes the full day for both boundaries (00:00:00 to 23:59:59).

## Manual Test

![alt text](image.png)

## Tests

Feature Tests with edge cases added
