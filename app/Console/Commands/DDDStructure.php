<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

// @author: Juanjo Ruiz (Github: jjruizdeveloper | youtube: @gogodev | discord: juanjo.ruiz)

class DDDStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ddd {context : The bounded context, such as admin, lms or job_request} {entity : The entity to create the DDD structure, books for example}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates DDD folder structure for the given entity';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $context = $this->argument('context');
        $entity = $this->argument('entity');

        $contextPascal = $this->pascalCase($context);
        $entityPascal = $this->pascalCase($entity);

        $uri = base_path('src/'. $contextPascal .'/'. $entityPascal);
        $this->info('Creating structure...');

        $dirs = [
            '/Domain',
            '/Domain/Entities',
            '/Domain/ValueObjects',
            '/Domain/Contracts',
            '/Application',
            '/Infrastructure',
            '/Infrastructure/Controllers',
            '/Infrastructure/Routes',
            '/Infrastructure/Validators',
            '/Infrastructure/Repositories',
            '/Infrastructure/Listeners',
            '/Infrastructure/Events',
        ];

        foreach ($dirs as $d) {
            File::makeDirectory($uri . $d, 0755, true, true);
            $this->info($uri . $d);
        }

        // api.php (module routes entry)
        $content = "<?php\n\n//use Src\\".$contextPascal."\\".$entityPascal."\\Infrastructure\\Controllers\\ExampleGETController;\n\n// Simple route example\n// Route::get('/', [ExampleGETController::class, 'index']);\n\n// Authenticated route example\n// Route::middleware(['auth:sanctum','activitylog'])->get('/', [ExampleGETController::class, 'index']);";
        File::put($uri . '/Infrastructure/Routes/api.php', $content);
        $this->info('Routes entry point added in ' . $uri . '/Infrastructure/Routes/api.php' );

        // link local routes in main routes/api.php using original context/entity for prefix
        $link = "\nRoute::prefix('" . $context . "_" . $entity . "')->group(base_path('src/" . $contextPascal . "/" . $entityPascal . "/infrastructure/routes/api.php'));\n";
        $link = "\nRoute::prefix('" . $context . "_" . $entity . "')->group(base_path('src/" . $contextPascal . "/" . $entityPascal . "/Infrastructure/Routes/api.php'));\n";
        File::append(base_path('routes/api.php'), $link);
        $this->info('Module routes linked in main routes directory.');

        // Example controller
        $controller = "<?php\n\nnamespace Src\\" . $contextPascal . "\\" . $entityPascal . "\\infrastructure\\controllers;\n\nuse App\\Http\\Controllers\\Controller;\n\nfinal class ExampleGETController extends Controller { \n\n public function index() { \n // TODO: DDD Controller content here \n }\n}";
        $controller = "<?php\n\nnamespace Src\\" . $contextPascal . "\\" . $entityPascal . "\\Infrastructure\\Controllers;\n\nuse App\\Http\\Controllers\\Controller;\n\nfinal class ExampleGETController extends Controller { \n\n public function index() { \n // TODO: DDD Controller content here \n }\n}";
        File::put($uri . '/Infrastructure/Controllers/ExampleGETController.php', $controller);
        $this->info('Example controller added');

        // Example validator
        $validator = "<?php\n\nnamespace Src\\" . $contextPascal . "\\" . $entityPascal . "\\infrastructure\\validators;\n\nuse Illuminate\\Foundation\\Http\\FormRequest;\n\nclass ExampleValidatorRequest extends FormRequest\n{\n    public function authorize()\n    {\n        return true;\n    }\n\n    public function rules()\n    {\n        return [\n            'field' => 'nullable|max:255'\n        ];\n    }\n\n}";
        $validator = "<?php\n\nnamespace Src\\" . $contextPascal . "\\" . $entityPascal . "\\Infrastructure\\Validators;\n\nuse Illuminate\\Foundation\\Http\\FormRequest;\n\nclass ExampleValidatorRequest extends FormRequest\n{\n    public function authorize()\n    {\n        return true;\n    }\n\n    public function rules()\n    {\n        return [\n            'field' => 'nullable|max:255'\n        ];\n    }\n\n}";
        File::put($uri . '/Infrastructure/Validators/ExampleValidatorRequest.php', $validator);
        $this->info('Example validation request added');

        $this->info('Structure ' . $entity . ' DDD successfully created.');

        return Command::SUCCESS;
    }

    private function pascalCase(string $value): string
    {
        $value = preg_replace('/[^a-zA-Z0-9]+/', ' ', $value);
        $words = preg_split('/\s+/', trim($value));
        $words = array_map(function ($w) {
            return ucfirst(strtolower($w));
        }, $words ?: []);

        return implode('', $words);
    }
}
