<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Exception;

class NotificationController extends Controller
{
    /**
     * Названия типов заявок на русском
     */
    private const FORM_TYPE_LABELS = [
        'designer'           => 'Вызов дизайнера',
        'showroom'           => 'Запись в шоурум',
        'quiz'               => 'Тест по кухне (расчёт цены)',
        'style-consultation' => 'Стилевая консультация',
        'consultation'       => 'Консультация',
        'general'            => 'Общая заявка',
    ];

    /**
     * Send service request notification email
     */
    public function sendServiceRequestNotification(Request $request)
    {
        try {
            Log::info('ZOV: Service request notification received', [
                'form_type' => $request->input('form_type'),
                'name'      => $request->input('name'),
            ]);

            $request->validate([
                'form_type'  => 'required|string|in:designer,showroom,quiz,style-consultation,consultation,general',
                'name'       => 'required|string|max:255',
                'phone'      => 'required|string|max:50',
                'message'    => 'nullable|string|max:2000',
                'source_url' => 'nullable|string|max:500',
                'extra'      => 'nullable|array',
            ]);

            $formTypeLabel = self::FORM_TYPE_LABELS[$request->form_type] ?? $request->form_type;

            // Get admin email from env
            $adminEmail = env('ADMIN_EMAIL', 'info@novostroy.org');

            // Prepare email content
            $emailData = [
                'form_type'      => $formTypeLabel,
                'client_name'    => $request->name,
                'phone'          => $request->phone,
                'client_message' => $request->message ?? 'Не указано',
                'source_url'     => $request->source_url ?? 'Не указано',
                'extra'          => $request->extra ?? [],
                'submitted_at'   => now()->format('d.m.Y H:i:s'),
            ];

            // Send email
            Mail::send('emails.service-request', $emailData, function ($msg) use ($adminEmail, $formTypeLabel) {
                $msg->to($adminEmail)
                    ->subject('ZOV — Новая заявка: ' . $formTypeLabel);
            });

            Log::info('ZOV: Service request notification sent successfully', [
                'form_type' => $request->form_type,
                'to'        => $adminEmail,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Уведомление отправлено.',
            ]);

        } catch (ValidationException $e) {
            Log::warning('ZOV: Service request notification validation failed', [
                'errors' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Некорректные данные.',
                'errors'  => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (Exception $e) {
            Log::error('ZOV: Service request notification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Не удалось отправить уведомление.',
                'errors'  => ['general' => ['Произошла ошибка при отправке.']],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
