<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image
        ]);

        $room = new Room();
        $room->name = $request->name;
        $room->description = $request->description;
        $room->capacity = $request->capacity;

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            // Save image to storage/app/public/rooms
            $path = $request->image->storeAs('rooms', $imageName, 'public');
            $room->image = 'storage/rooms/' . $imageName; // Store image path in DB
        }

        $room->save();

        return redirect()->route('rooms.index');
    }



    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $room = Room::findOrFail($id);
        $room->name = $request->name;
        $room->description = $request->description;
        $room->capacity = $request->capacity;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($room->image && Storage::disk('public')->exists(str_replace('storage/', '', $room->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $room->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            // Save new image to storage/app/public/rooms
            $path = $request->image->storeAs('rooms', $imageName, 'public');
            $room->image = 'storage/rooms/' . $imageName; // Store new image path in DB
        }

        $room->save();

        return redirect()->route('rooms.index');
    }



    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
