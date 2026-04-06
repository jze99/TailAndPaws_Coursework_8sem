<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function edit()
    {
        $contact = Contact::first();

        if (!$contact) {
            $contact = Contact::create([
                'name' => 'Хвостики и лапки'
            ]);
        }

        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request)
    {
        $contact = Contact::first();

        if (!$contact) {
            $contact = Contact::create();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,svg|max:1024',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'work_hours' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'vkontakte' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string'
        ]);

        if ($request->hasFile('logo')) {
            if ($contact->logo && file_exists(public_path('assets/images/logo/' . $contact->logo))) {
                unlink(public_path('assets/images/logo/' . $contact->logo));
            }

            $logoFile = $request->file('logo');
            $logoName = time() . '_logo.' . $logoFile->getClientOriginalExtension();
            $logoFile->move(public_path('assets/images/logo'), $logoName);
            $contact->logo = $logoName;
        }

        if ($request->hasFile('favicon')) {
            if ($contact->favicon && file_exists(public_path('assets/images/logo/' . $contact->favicon))) {
                unlink(public_path('assets/images/logo/' . $contact->favicon));
            }

            $faviconFile = $request->file('favicon');
            $faviconName = time() . '_favicon.' . $faviconFile->getClientOriginalExtension();
            $faviconFile->move(public_path('assets/images/logo'), $faviconName);
            $contact->favicon = $faviconName;
        }

        $contact->update([
            'name' => $request->name,
            'description' => $request->description,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'work_hours' => $request->work_hours,
            'telegram' => $request->telegram,
            'whatsapp' => $request->whatsapp,
            'vkontakte' => $request->vkontakte,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords
        ]);

        return redirect()->route('admin.contacts.edit')
            ->with('success', 'Данные сайта успешно обновлены');
    }
}
