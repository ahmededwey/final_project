$models = @(
    "Company",
    "JobApplication",
    "JobCategory",
    "JobVacancy",
    "Resume"
   
)

foreach ($model in $models) {

    Write-Host "`nCreating $model..." -ForegroundColor Cyan

    # Model + Migration
    php artisan make:model $model -m

    # Factory
    php artisan make:factory "${model}Factory"

    # Seeder
    php artisan make:seeder "${model}Seeder"

    # Resource Controller
    php artisan make:controller "${model}Controller" --resource

    # Policy
    php artisan make:policy "${model}Policy" --model=$model

    # Store Request
    php artisan make:request "Store${model}Request"

    # Update Request
    php artisan make:request "Update${model}Request"

    Write-Host "$model completed!" -ForegroundColor Green
}

Write-Host "`nAll models completed!" -ForegroundColor Yellow