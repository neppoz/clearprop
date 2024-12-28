# ClearProp

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F2484af29-402d-4085-9241-2c934fe4aded%3Fdate%3D1&style=flat)](https://forge.laravel.com/servers/822733/sites/2404649)
![GitHub issues](https://img.shields.io/github/issues/neppoz/clearprop)
![GitHub stars](https://img.shields.io/github/stars/neppoz/clearprop)
![GitHub forks](https://img.shields.io/github/forks/neppoz/clearprop)
![GitHub license](https://img.shields.io/github/license/neppoz/clearprop)

ClearProp is an open-source Laravel-based application designed for flight schools and aeroclubs. This project aims to
simplify aircraft management, bookings, and member data handling. With extensibility at its core, ClearProp is the ideal
solution for aviation organizations.

---

## 🛠️ Key Features

- **Aircraft Management**: Organize and manage your fleet with ease.
- **Aircraft Rating**: Dynamic rule based rating for pilots and aircraft.
- **Real-Time Booking System**: Avoid conflicts with intuitive scheduling tools.
- **Member Management**: Role-based access control and member data storage.
- **Flight Logs**: Track flights of your students and pilots.
- **Responsive Design**: Seamless experience on any device.
- **Multilingual Support**: Enable easy translation into multiple languages.

and much more to come....

![Feature Screenshot Placeholder](https://via.placeholder.com/800x400.png?text=Feature+Screenshot)

---

## 🧩 Demo

Try the live demo here: [Demo URL Placeholder](#)

![Demo Screenshot Placeholder](https://via.placeholder.com/800x400.png?text=Demo+Screenshot)

---

## 🚀 Installation

Follow these steps to set up ClearProp on your local environment.

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or another compatible database
- A web server (Apache, Nginx, etc.)

### Installation Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/neppoz/clearprop.git
   cd clearprop
   git checkout v2
   ```

2. **Install Dependencies**
    - PHP Dependencies:
      ```bash
      composer install
      ```
    - Node.js Dependencies:
      ```bash
      npm install && npm run dev
      ```

3. **Set Environment Variables**
   ```bash
   cp .env.example .env
   ```
   Update `.env` with your database credentials and other configurations.

4. **Migrate the Database**
   ```bash
   php artisan migrate --seed
   ```
   Please note: On migration you can set the admin user and the password.

5. **Link Storage**
   ```bash
   php artisan storage:link
   ```

6. **Start the Local Server**
   ```bash
   php artisan serve
   ```

Visit [http://localhost:8000](http://localhost:8000) to access the application.

---

## 📚 Documentation

For detailed usage instructions and advanced configurations, refer to
the [Wiki](https://github.com/neppoz/clearprop/wiki).

---

## 🛡️ Security

If you discover any security vulnerabilities, please report them by
emailing [sec@clearprop.aero](mailto:neppo@example.com).

---

## 🤝 Contributions

We welcome contributions! Follow these steps to contribute:

1. **Fork** the repository.
2. Create a new **branch** (`git checkout -b feature-name`).
3. Make your changes.
4. Open a **pull request**.

Check the [CONTRIBUTING.md](CONTRIBUTING.md) for more details.

---

## 📜 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## ❤️ Acknowledgments

- [Laravel Filament](https://filamentphp.com/)
- leandrocfe/filament-apex-charts
- saade/filament-fullcalendar"
- filament/spatie-laravel-settings-plugin
- https://github.com/spatie/laravel-settings
-
- [Spatie packages](https://filamentphp.com/)
- The **entire Laravel community** for providing amazing tools and support.

![Footer Placeholder](https://via.placeholder.com/800x200.png?text=Thank+You+for+using+ClearProp)
