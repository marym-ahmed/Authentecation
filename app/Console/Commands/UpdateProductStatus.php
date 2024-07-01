<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class UpdateProductStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-product-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update product status every minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::where('quantity', 0)->update(['status' => 0]);

        $this->info('Product updated successfully');
    }
}
