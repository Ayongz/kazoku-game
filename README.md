# 🎮 Kazoku Game

**A competitive money-earning web game built with Laravel**

Kazoku Game is an interactive browser-based game where players compete to earn virtual money, upgrade abilities, and climb the leaderboard. Built with Laravel and Bootstrap, it features a comprehensive economy system with passive income mechanics and competitive gameplay.

## 🎯 Game Overview

### What is Kazoku Game?

Kazoku Game is a **money accumulation strategy game** where players:
- **Earn money** through active clicking (limited attempts per hour)
- **Upgrade abilities** to unlock passive income and steal mechanics
- **Compete globally** on leaderboards for daily prize pools
- **Build strategies** to maximize earnings and climb rankings

### Core Gameplay Loop

1. **📱 Earn Money**: Click "Earn Money Now" to get random amounts (1,000-10,000 IDR)
2. **🏪 Visit Store**: Upgrade steal abilities and auto-earning capabilities  
3. **🏆 Compete**: Climb the leaderboard to win daily prize pools
4. **💰 Strategize**: Balance active earning vs passive income investments

---

## 🎮 Game Features

### 💵 **Active Earning System**
- **Random Rewards**: Each attempt earns 1,000-10,000 IDR
- **Limited Attempts**: Players get attempts that regenerate hourly
- **Prize Pool Contribution**: 10% of earnings contribute to global prize pool

### 🤖 **Auto Earning (Passive Income)**
- **Progressive Levels**: Upgrade from Level 1-20
- **Passive Rate**: Earn 0.05% per level per hour of your total money
- **Maximum Potential**: Level 20 = 1.0% hourly passive income
- **24/7 Income**: Earn money even when offline

### 🎭 **Steal Ability**
- **Heist Mechanics**: Steal from other players and the global prize pool
- **Success Rates**: 20% success chance per level (max 80% at Level 4+)
- **Risk vs Reward**: Higher levels steal larger amounts
- **Strategic Gameplay**: Time your heists for maximum profit

### 🏆 **Competitive Features**
- **Daily Leaderboard**: Top 10 richest players displayed
- **Global Prize Pool**: Accumulated from all player contributions
- **Daily Winner**: Richest player wins entire prize pool at midnight
- **Real-time Rankings**: See your position among all players

### 📊 **Game Economy**
- **Balanced Pricing**: Upgrade costs scale with player progression
- **Inflation Control**: Limited attempts prevent economy breaking
- **Prize Pool Cycling**: Daily redistribution keeps economy active
- **Multiple Income Streams**: Active + Passive + Stealing strategies

---

## 🛠️ Technical Implementation

### **Built With Laravel 12**
- **MVC Architecture**: Clean separation of game logic and presentation
- **Eloquent ORM**: Efficient database operations for user data and game state
- **Middleware Protection**: All game routes require authentication
- **Scheduled Commands**: Automated hourly and daily game mechanics

### **Frontend Technologies**
- **Bootstrap 5**: Responsive UI design with modern components
- **Font Awesome**: Rich iconography for enhanced user experience
- **Blade Templates**: Server-side rendering for optimal performance
- **Custom CSS**: Polished styling with animations and gradients

### **Database Schema**
```sql
users:
- money_earned (BIGINT): Player's total accumulated money
- attempts (SMALLINT): Available earning attempts
- steal_level (SMALLINT): Steal ability level (0-5)
- auto_earning_level (SMALLINT): Auto earning level (0-20)

game_settings:
- global_prize_pool (DECIMAL): Community prize pool
```

### **Automated Systems**
- **Hourly Attempt Reset**: `game:add-attempts` - Adds 5 attempts (max 20)
- **Hourly Auto Earning**: `game:process-auto-earning` - Processes passive income
- **Daily Prize Distribution**: `game:distribute-prize` - Awards richest player at midnight

---

## 🚀 Getting Started

### **Prerequisites**
- PHP 8.2+
- Composer
- MySQL/SQLite Database
- Node.js & NPM

### **Installation**

1. **Clone the repository**
   ```bash
   git clone https://github.com/Ayongz/kazoku-game.git
   cd kazoku-game
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - Update `.env` with your database credentials
   - Set `APP_NAME="Kazoku Game"`

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Build assets**
   ```bash
   npm run dev
   ```

7. **Start the application**
   ```bash
   php artisan serve
   ```

8. **Start the scheduler** (for automated game mechanics)
   ```bash
   php artisan schedule:start
   ```

---

## 🎮 Game Mechanics

### **Earning Progression**
| Action | Base Amount | Frequency | Contribution to Prize Pool |
|--------|-------------|-----------|---------------------------|
| Manual Earning | 1,000-10,000 IDR | Per attempt | 10% |
| Auto Earning (Lv1) | 0.05% of total/hour | Hourly | 10% |
| Auto Earning (Lv20) | 1.0% of total/hour | Hourly | 10% |
| Stealing (Lv1) | 1x manual amount | Manual | Reduces pool |

### **Upgrade Costs**
- **Steal Ability**: 5,000 × level (5K, 10K, 15K, 20K, 25K)
- **Auto Earning**: 10,000 × level (10K, 20K, 30K, ..., 200K)

### **Daily Prize Pool**
- Accumulates from 10% of all player earnings
- Winner: Player with highest total money at midnight
- Prize pool resets to 0 after distribution
- Creates daily competition and engagement

---

## 🎯 Game Strategy Guide

### **Early Game (0-50K IDR)**
1. Focus on manual earning to build initial capital
2. Purchase Auto Earning Level 1-3 for passive income
3. Save up for Steal Level 1 to unlock heist mechanics

### **Mid Game (50K-500K IDR)**
1. Balance auto earning upgrades with steal levels
2. Time heists when global prize pool is high
3. Monitor leaderboard for competitive positioning

### **Late Game (500K+ IDR)**
1. Maximize auto earning levels (15-20)
2. Master steal timing for optimal profits
3. Compete daily for prize pool victories

---

## 📱 User Interface

### **Game Dashboard**
- Real-time money display with formatting
- Attempt counter with hourly reset indication
- Global prize pool status
- Quick action buttons for earning and stealing

### **Store Page**
- Visual upgrade progression
- Cost/benefit analysis for each upgrade
- Current ability status and next level preview
- Secure purchase system with validation

### **Leaderboard (Home)**
- Top 10 richest players
- Personal ranking and statistics
- Game-wide statistics (total money, players)
- Ability level indicators for competitive analysis

---

## 🔧 Development Features

### **Security**
- Authentication required for all game features
- CSRF protection on all forms
- Input validation and sanitization
- Secure session management

### **Performance**
- Optimized database queries with Eloquent
- Efficient scheduling system
- Responsive design for all devices
- Minimal JavaScript for fast loading

### **Maintainability**
- Clean MVC architecture
- Comprehensive commenting
- Modular component design
- Easy configuration management

---

## 📈 Future Enhancements

- **Guilds/Teams**: Collaborative gameplay features
- **Achievement System**: Unlock rewards for milestones
- **Item Shop**: Purchasable boosts and cosmetics
- **Mini-Games**: Additional earning methods
- **Social Features**: Friend systems and messaging
- **Mobile App**: Native iOS/Android applications

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🎮 Start Playing

Ready to join the money game? [Register now](http://localhost:8000/register) and start your journey to the top of the leaderboard!

**May the best earner win! 💰**
