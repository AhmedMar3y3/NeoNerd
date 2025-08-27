<?php

namespace App\Http\Requests\Doctor\Lesson;

use App\Http\Requests\BaseRequest;

class UpdateLessonRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'video_url' => [
                'required',
                'url',
                'max:500',
            ],
            'duration' => [
                'required',
                'string',
                'regex:/^\d{1,2}:\d{2}$/',
            ],
            'is_free' => [
                'boolean',
            ],
            // 'file' => [
            //     'nullable',
            //     'file',
            //     'mimes:pdf,doc,docx,ppt,pptx,txt',
            //     'max:10240',
            // ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الدرس مطلوب',
            'title.string' => 'عنوان الدرس يجب أن يكون نص',
            'title.max' => 'عنوان الدرس لا يمكن أن يتجاوز 255 حرف',
            'video_url.required' => 'رابط الفيديو مطلوب',
            'video_url.url' => 'رابط الفيديو يجب أن يكون رابط صحيح',
            'video_url.max' => 'رابط الفيديو لا يمكن أن يتجاوز 500 حرف',
            'duration.required' => 'مدة الدرس مطلوبة',
            'duration.regex' => 'مدة الدرس يجب أن تكون بصيغة MM:SS',
            'is_free.boolean' => 'حقل مجاني يجب أن يكون صحيح أو خطأ',
            'file.file' => 'الملف يجب أن يكون ملف صحيح',
            'file.mimes' => 'صيغة الملف يجب أن تكون PDF, DOC, DOCX, PPT, PPTX, أو TXT',
            'file.max' => 'حجم الملف لا يمكن أن يتجاوز 10 ميجابايت',
        ];
    }
}
