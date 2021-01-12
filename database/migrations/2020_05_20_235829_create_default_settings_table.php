<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
                ->constrained()
                ->onDelete('cascade');
              $table->foreignId('language_id')
                ->default(1)
                ->constrained();
            $table->foreignId('currency_id')
                ->default(1)
                ->constrained();
            $table->integer('start_day_financial')->default(1);
            $table->integer('end_day_financial')->default(31);
            $table->integer('start_month_financial')->default(1);
            $table->integer('end_month_financial')->default(12);
            $table->integer('auto_convertion_rate')->default(0);
            $table->decimal('currency_convertion_margin',10,2)->default(0.00);
            $table->integer('currency_decimal_place')->default(2);
            $table->integer('exclusive_tax')->default(1);
            $table->integer('show_header_tax')->default(0);
            $table->integer('breakup_tax_invoice_folio')->default(0);
            $table->integer('display_tax_invoice')->default(0);
            $table->integer('group_tax_pos')->default(0);
            $table->integer('breakup_tax_account_statement')->default(0);
            $table->integer('display_tax_statement')->default(0);

            $table->integer('adjustment_invoice_folio')->default(0);
            $table->integer('account_folio_date')->default(0);
            $table->integer('show_deposit_alert_checkin')->default(0);
            //Weekdays table
            $table->string('date_format')->default('dd/MM/yyyy');
            $table->foreignId('time_zone_id')
                ->default(1)
                ->constrained();
            $table->integer('time_format')->default(1);
            $table->time('checkin_time')->default('12:00');
            $table->time('checkout_time')->default('12:00');
            $table->integer('age_maximum_child')->default(12);
            $table->integer('minimum_child_age')->default(0);
            $table->integer('age_maximum_infant')->default(0);
            $table->decimal('travel_agent_commission', 10, 2)->default(0.00);
            $table->decimal('corporate_discount', 10, 2)->default(0.00);
            $table->time('time_night_audit')->default('00:00');
            $table->integer('run_audit')->default(2); //1 mismo dia 2-Proximo dia
            $table->integer('audit_mark_checkout')->default(1);
            $table->integer('audit_mark_checkin_noshow')->default(1); //1--Check in 2--No show

            //House Keeping

            $table->integer('audit_housekeeping_occupied')->default(2);
            $table->integer('audit_housekeeping_vacant')->default(1);
            $table->integer('audit_housekeeping_checkout')->default(2);
            $table->integer('audit_housekeeping_change_room')->default(3);

            //Cancelation
            $table->decimal('minimum_cancellation_fee', 10, 2)->default(0.00);

            //Cancelacion y relacion
            //Booking Policy y relacion
            //Web Policy y relacion


            //Early Check In/Check Out

            $table->integer('early_checkin_hour')->default(0);
            $table->decimal('early_checkin_charge',10,2)->default(0);
            $table->integer('early_checkin_charge_type')->default(2);
            $table->integer('early_checkout_hour')->default(0);
            $table->integer('early_checkout_hour_type')->default(1);
            $table->decimal('early_checkout_charge',10,2)->default(0);
            $table->integer('early_checkout_charge_type')->default(2);
            $table->integer('late_checkout_hour')->default(0);
            $table->decimal('late_checkout_charge',10,2)->default(0);
            $table->integer('late_checkout_charge_type')->default(2);

            $table->integer('charge_noshow_time')->default(12);
            $table->integer('charge_noshow_consider')->default(2); //1- Hora Llegada 2-Checkin time

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_settings');
    }
}
