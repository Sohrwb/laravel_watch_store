<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // کاربر مربوط به این فاکتور
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // شماره یکتای فاکتور، مثلاً: 20250731-00001
            $table->string('invoice_number')->unique();

            // جمع مبلغ فاکتور
            $table->integer('total_price');

            // وضعیت پرداخت: در انتظار یا پرداخت‌شده
            $table->enum('status', ['pending', 'paid'])->default('pending');

            // تاریخ و زمان پرداخت (فقط در صورت paid پر می‌شود)
            $table->timestamp('payment_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
