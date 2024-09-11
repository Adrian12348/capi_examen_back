<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Muestra una lista de contactos
    public function index()
    {
        $contacts = Contact::with(['phones', 'emails', 'addresses'])->get();
        return response()->json($contacts);
    }

    // Muestra el formulario para crear un nuevo contacto
    public function create()
    {
    }

    // Almacena un nuevo contacto en la base de datos
    public function store(Request $request)
    {
        // Validación de los datos del contacto con mensajes personalizados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'birthday' => 'required|date', 
            'website' => 'nullable|url',
            'company' => 'nullable|string',
            'phones' => 'nullable|array',
            'phones.*' => 'nullable|string',
            'emails' => 'nullable|array',
            'emails.*' => 'nullable|email',
            'addresses' => 'nullable|array',
            'addresses.*' => 'nullable|string',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'birthday.required' => 'La fecha de nacimiento es obligatoria.',
            'birthday.date' => 'La fecha de nacimiento debe ser una fecha válida.',
        ]);

        // Crear el contacto
        $contact = Contact::create([
            'name' => $validated['name'],
            'notes' => $validated['notes'],
            'birthday' => $validated['birthday'],
            'website' => $validated['website'],
            'company' => $validated['company'],
        ]);

        // Crear teléfonos relacionados
        if (isset($validated['phones']) && is_array($validated['phones'])) {
            foreach ($validated['phones'] as $phone) {
                if (!empty($phone)) {
                    $contact->phones()->create([
                        'phone' => $phone,
                    ]);
                }
            }
        }

        // Crear correos electrónicos relacionados
        if (isset($validated['emails']) && is_array($validated['emails'])) {
            foreach ($validated['emails'] as $email) {
                if (!empty($email)) {
                    $contact->emails()->create([
                        'email' => $email,
                    ]);
                }
            }
        }

        // Crear direcciones relacionadas
        if (isset($validated['addresses']) && is_array($validated['addresses'])) {
            foreach ($validated['addresses'] as $address) {
                if (!empty($address['address'])) {
                    $contact->addresses()->create([
                        'address' => $address,
                    ]);
                }
            }
        }

        return response()->json($contact->load(['phones', 'emails', 'addresses']), 201);
    }


    // Muestra un contacto específico
    public function show(Contact $contact)
    {
        $contact->load(['phones', 'emails', 'addresses']);
        return response()->json($contact);
    }

    // Muestra el formulario para editar un contacto existente
    public function edit(Contact $contact)
    {
    }

    // Actualiza un contacto en la base de datos
    public function update(Request $request, Contact $contact)
    {

        // Validación de los datos del contacto con mensajes personalizados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'birthday' => 'required|date', 
            'website' => 'nullable|url',
            'company' => 'nullable|string',
            'phones' => 'nullable|array',
            'phones.*' => 'nullable|string',
            'emails' => 'nullable|array',
            'emails.*' => 'nullable|email',
            'addresses' => 'nullable|array',
            'addresses.*' => 'nullable|string',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'birthday.required' => 'La fecha de nacimiento es obligatoria.',
            'birthday.date' => 'La fecha de nacimiento debe ser una fecha válida.',
        ]);

        // Actualizar el contacto
        $contact->update([
            'name' => $validated['name'],
            'notes' => $validated['notes'],
            'birthday' => $validated['birthday'],
            'website' => $validated['website'],
            'company' => $validated['company'],
        ]);

        // Actualizar teléfonos relacionados
        if (isset($validated['phones']) && is_array($validated['phones'])) {
            // Primero eliminar teléfonos existentes
            $contact->phones()->delete();

            // Luego crear nuevos teléfonos
            foreach ($validated['phones'] as $phone) {
                if (!empty($phone)) {
                    $contact->phones()->create([
                        'phone' => $phone,
                    ]);
                }
            }
        }

        // Actualizar correos electrónicos relacionados
        if (isset($validated['emails']) && is_array($validated['emails'])) {
            // Primero eliminar correos electrónicos existentes
            $contact->emails()->delete();

            // Luego crear nuevos correos electrónicos
            foreach ($validated['emails'] as $email) {
                if (!empty($email)) {
                    $contact->emails()->create([
                        'email' => $email,
                    ]);
                }
            }
        }

        // Actualizar direcciones relacionadas
        if (isset($validated['addresses']) && is_array($validated['addresses'])) {
            // Primero eliminar direcciones existentes
            $contact->addresses()->delete();

            // Luego crear nuevas direcciones
            foreach ($validated['addresses'] as $address) {
                if (!empty($address['address'])) {
                    $contact->addresses()->create([
                        'address' => $address,
                    ]);
                }
            }
        }

        return response()->json($contact->load(['phones', 'emails', 'addresses']));
    }

    // Elimina un contacto de la base de datos
    public function destroy(Contact $contact)
    {
        try {
            // Eliminar correos electrónicos relacionados
            $contact->emails()->delete();

            // Eliminar teléfonos relacionados
            $contact->phones()->delete();

            // Eliminar direcciones relacionadas
            $contact->addresses()->delete();

            // Finalmente, eliminar el contacto
            $contact->delete();

            return response()->json(['message' => 'Contact deleted successfully.'], 200);
        } catch (\Exception $e) {
            // Manejar excepciones y devolver un error adecuado
            return response()->json(['error' => 'An error occurred while deleting the contact.'], 500);
        }
    }
}
