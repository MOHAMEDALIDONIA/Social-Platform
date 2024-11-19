# Social Networking Platform
A Laravel-based social networking platform enabling user interactions through profiles, friend connections, posts, comments, and likes.

## Features
- **User Authentication**: Registration, login, logout, and password reset.
- **User Profiles**: Profile creation and editing.
- **Friend Connections**: Send, accept, and reject friend requests.
- **Posts**: Create, edit, and delete posts with text and images.
- **Comments & Likes**: Comment on posts and view who liked them.
- **API Authentication**: Secure API access with Laravel Sanctum/Passport.
- **Real-time Notifications**: Using Laravel Echo and WebSockets.

## Technologies Used
- **Laravel**: Backend framework
- **Blade Templates**: Frontend templating
- **Laravel Sanctum**: API authentication
- **Laravel Echo & Pusher**: Real-time notifications
-  **Database**: MySQL, with Laravel migrations and seeders

  ## Database Structure
- **Users**: Contains user information.
- **Posts**: Stores posts created by users.
- **Comments**: Comments on posts, linked to users and posts.
- **Likes**: Records likes from users on posts.
- **Connections**: Manages friend requests and relationships between users.

### Relationships
- **User - Post**: One-to-Many
- **Post - Comment**: One-to-Many
- **User - Connection**: Many-to-Many
- **Post - Like**: Many-to-Many



