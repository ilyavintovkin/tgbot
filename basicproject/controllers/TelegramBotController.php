<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use app\models\Tguser;

class TelegramBotController extends Controller
{
    public function actionSetWebhook()
    {
        // Токен вашего бота
        $token = '8181145365:AAFMWW7j7Ag8NxDiKyJG4YbGmkyGs_sb5Es'; 
        // URL для webhook (обратите внимание на использование реального URL вашего сервера)
        $webhookUrl = 'https://5y9vc4-213-108-21-154.ru.tuna.am/telegram-bot/webhook'; // Замените на ваш реальный URL
        // Формируем URL для установки webhook
        $url = 'https://api.telegram.org/bot' . $token . '/setWebhook?url=' . urlencode($webhookUrl);
        // Отправляем запрос на установку webhook
        $response = file_get_contents($url);
        // Декодируем ответ от Telegram API
        $responseData = json_decode($response, true);
        // Если ответ успешный
        if ($responseData['ok']) {
            return 'Webhook успешно установлен!';
        } else {
            // Если произошла ошибка, выводим описание ошибки
            return 'Ошибка при установке webhook: ' . $responseData['description'];
        }
    }
    public function actionWebhook()
    {
        // Инициализация Telegram API
        $telegram = new Api('8181145365:AAFMWW7j7Ag8NxDiKyJG4YbGmkyGs_sb5Es');

        // Получаем обновление (сообщение от пользователя)
        $update = $telegram->getWebhookUpdate();

        // Проверяем, пришло ли сообщение от пользователя
        if ($update->getMessage()) {
            $message = $update->getMessage(); // Получаем объект сообщения

            $message->getMessageId(); // ID сообщения
            $chatId = $message->getChat()->getId(); // ID чата
            $userId = $message->getFrom()->getId(); // ID пользователя
            $username = $message->getFrom()->getUsername();// имя пользователя
            $text = $message->getText(); // Текст сообщения

            $existingUser = Tguser::findOne(['user_id' => $userId]);
                 if (!$existingUser) {
                    // Если пользователь не найден, добавляем нового
                    $newUser = new Tguser();
                    $newUser->chat_id = $chatId;
                    $newUser->user_id = $userId;
                    $newUser->username = $username;
                    $newUser->step = 'main_menu_step'; 
                    if ($newUser->save()) {
                        // Пользователь успешно сохранён
                        \Yii::info("Пользователь добавлен в базу: $username");
                    } 
                    else {
                        // Ошибка сохранения, логируем ошибки
                        \Yii::error("Ошибка сохранения пользователя: " . json_encode($newUser->errors));
                    }
                }           
                else {
                    $existingUser->step = 'jurist_menu_step';
                    \Yii::info("Пользователь уже существует: $username");
                    if ($existingUser->save(false)) { // Сохраняем без валидации
                        \Yii::info("Шаг для пользователя $username изменён на 'jurist_menu'");
                    } else {
                        \Yii::error("Ошибка обновления step для пользователя: $username");
                    }
                }
        }
    }
}


