<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // e.g., 'stock_expiry', 'purchase_alert', etc.
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false); // Indicates if the notification has been read
            $table->timestamp('read_at')->nullable(); // Timestamp when the notification was read
            $table->string('action_url')->nullable(); // URL to redirect when the notification is clicked
            $table->string('icon')->nullable(); // Optional icon for the notification
            $table->string('status')->default('unread'); // Status of the notification (e.g., 'unread', 'read', 'archived')
            $table->string('priority')->default('normal'); // Priority of the notification (e.g., 'low', 'normal', 'high')
            $table->json('data')->nullable(); // Additional data related to the notification, stored as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
