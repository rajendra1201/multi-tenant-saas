# Multi-Tenant SaaS Application with Chatbot Onboarding

A comprehensive Laravel-based multi-tenant SaaS platform that enables businesses to create their online presence through an AI-powered chatbot onboarding system.

## Features

- 🤖 **AI Chatbot Onboarding**: Interactive setup process with intelligent assistant
- 🏢 **Multi-Tenant Architecture**: Isolated tenant environments with custom subdomains
- 🎨 **Dynamic Themes**: Business-specific themes (Gym, Kirana, Clothing, Restaurant, Salon)
- 🖼️ **Auto Asset Generation**: AI-powered logo, banner, and description creation
- 📦 **Complete Management**: Products, services, blog, offers management
- 🔒 **Secure**: Proper tenant isolation and data security

## Supported Business Types

- **Gym & Fitness Centers**: Memberships, trainers, classes, equipment
- **Kirana Stores**: Groceries, daily essentials, household items
- **Clothing Stores**: Fashion items, accessories, custom tailoring
- **Restaurants**: Menu management, reservations, catering
- **Beauty Salons**: Services, staff management, appointments

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM

### Step 1: Clone and Install Dependencies
```bash
# Extract the zip file and navigate to the project
cd multi-tenant-saas

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### Step 2: Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Configure Database
Edit `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=multi_tenant_saas
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 4: OpenAI Configuration (Optional)
For AI asset generation, add your OpenAI API key in `.env`:
```
OPENAI_API_KEY=your-openai-api-key
```

### Step 5: Run Migrations
```bash
# Run central database migrations
php artisan migrate

# Install tenancy
php artisan tenancy:install
```

### Step 6: Storage Setup
```bash
# Create symbolic link for storage
php artisan storage:link
```

### Step 7: Start the Application
```bash
# Start the development server
php artisan serve

# In another terminal, start the queue worker
php artisan queue:work
```

## Usage

### Creating Your First Business

1. Visit `http://localhost:8000`
2. Click "Create Your Business"
3. Chat with the AI assistant:
   - Type "start" to begin
   - Provide your business name
   - Enter owner information
   - Select business type
   - Confirm details

### Accessing Your Business Dashboard

After creation, access your business at:
`http://your-business-name.localhost:8000`

### Managing Your Business

From the dashboard, you can:
- Add and manage products
- Create and manage services
- Write blog posts
- Create promotional offers
- Customize business settings

## Architecture

### Multi-Tenancy
- **Single Database**: All tenants share the same database with proper isolation
- **Subdomain Routing**: Each business gets its unique subdomain
- **Tenant Context**: Automatic tenant resolution and data scoping

### Theme System
- **Business-Specific Themes**: Automatic theme assignment based on business type
- **CSS Variables**: Dynamic color schemes and styling
- **Customizable**: Easy theme modification and extension

### Asset Generation
- **AI Integration**: OpenAI API for content and asset generation
- **Fallback System**: Text-based assets when AI is unavailable
- **Async Processing**: Background job processing for better performance

## File Structure

```
multi-tenant-saas/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   ├── Services/            # Business logic services
│   ├── Jobs/                # Background jobs
│   └── Conversations/       # BotMan conversations
├── config/                  # Configuration files
├── database/
│   ├── migrations/          # Central database migrations
│   └── migrations/tenant/   # Tenant-specific migrations
├── resources/
│   └── views/              # Blade templates
└── routes/                 # Application routes
```

## Configuration

### Business Types
Edit `app/Services/BusinessTypeService.php` to add new business types or modify existing ones.

### Themes
Modify `app/Services/ThemeService.php` to customize themes or add new ones.

### Chatbot Conversations
Extend `app/Conversations/OnboardingConversation.php` to modify the onboarding flow.

## Troubleshooting

### Common Issues

1. **"Attempt to read property 'headers' on null"**
   - Ensure all controllers return valid responses
   - Check that routes are properly defined

2. **Tenant not found**
   - Verify subdomain configuration
   - Check tenant domain records

3. **Assets not generating**
   - Verify OpenAI API key configuration
   - Check queue worker is running
   - Review job logs for errors

### Debug Mode
Enable debug mode in `.env`:
```
APP_DEBUG=true
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For support and questions:
- Check the troubleshooting section
- Review Laravel documentation
- Check BotMan documentation for chatbot issues
- Review Tenancy package documentation for multi-tenant issues

## Roadmap

- [ ] Advanced AI asset generation
- [ ] More business types
- [ ] Enhanced theme customization
- [ ] Mobile application
- [ ] Payment integration
- [ ] Advanced analytics
