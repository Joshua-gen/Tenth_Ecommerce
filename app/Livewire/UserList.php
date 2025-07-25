<?php

namespace App\Livewire;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Livewire\Component;

class UserList extends Component
{
    use WithPagination;

    public $isOpen = false; 
    public $search = '';

    public $isUser = false;

    // User data for editing
    public $userId, $name, $email;

    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'confirmed'],
        'role' => ['required', 'string']
    ];

    public function closeCreate()
    {
        $this->isUser = false;
    }

    public function openCreate()
    {
        $this->isUser = true;
    }

    // Open Modal
    public function openModal($id)
    {
        $user = User::find($id);

        if ($user) {
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->isOpen = true;
        }
    }

    // Close Modal
    public function closeModal()
    {
        $this->reset(['userId', 'name', 'email', 'isOpen']);
    }

    // Update User
    public function update()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($this->userId) {
            $user = User::find($this->userId);

            if ($user) {
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);

                session()->flash('message', 'User updated successfully.');
            }
        }

        $this->closeModal();
    }

    //create user
    public function createUser()
    {
        $validated = $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole($this->role);

        session()->flash('success', 'User created successfully.');

        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);

        $this->isUser = false;
    }

    // Delete User
    public function delete($id)
    {
        User::find($id)?->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
                     ->orderBy('created_at', 'desc')
                     ->paginate(5);

        return view('livewire.user-list', compact('users'));
    }
}
