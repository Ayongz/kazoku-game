# 🎮 Kazoku Game

## 💸 Top Up Mechanism
Kazoku Game features a Top Up system where players can purchase in-game packages to boost their progress. The Top Up process works as follows:
- Players choose from available packages (Random Box or Treasure) with different quantities and shield durations.
- Each package has a fixed cost (IDR 50,000 or IDR 100,000) and grants either random boxes or treasures, plus shield protection (6h or 12h).
- After submitting a Top Up request, the player must wait for admin approval.
- Admins can approve or reject requests. Approved requests immediately grant the items and add shield duration (stacking if already active).
- All Top Up transactions are tracked in the player's history, showing package, cost, status, and timestamp.
- The leaderboard (scoreboard) displays total top up amounts for all players, calculated using the actual cost of approved packages.

---

**A comprehensive RPG-style money-earning web game built with Laravel**

Kazoku Game is an advanced browser-based strategy RPG where players compete to earn virtual money, level up, select classes, upgrade abilities, and dominate the leaderboard. Built with Laravel and Bootstrap, it features a complex economy system with day/night cycles, PvP mechanics, class systems, and prestige progression.

## 🎯 Game Overview

### What is Kazoku Game?

Kazoku Game is a **multi-layered RPG strategy game** where players:
- **🏴‍☠️ Treasure Hunt**: Open treasures with day/night risk systems and rare treasure discoveries
- **⚡ Level & Experience**: Gain XP, level up, and unlock new features (Auto-click at Level 2!)
- **🎭 Class Selection**: Choose from 7 unique classes at Level 4, advance at Level 8
- **🛡️ PvP Combat**: Steal from players, defend with shields, counter-attack, and intimidate
- **🎰 Gambling Hall**: Test your luck with coin flip games and treasure fusion
- **📦 Inventory System**: Collect and open random boxes for rare rewards
- **👑 Prestige System**: Elite passive income for veteran players

### Core Gameplay Loop

1. **�️ Open Treasures**: Click to consume treasure and earn money (100-2,000 IDR base)
2. **�☀️ Time Strategy**: Safe day mode vs risky night mode with 5% rare treasure chance
3. **🏪 Upgrade Store**: Purchase 15+ different upgrade types and abilities
4. **🎯 Class Powers**: Leverage unique class abilities for specialized gameplay
5. **🏆 Compete**: Dominate leaderboards and win daily prize pools
6. **� Prestige**: Unlock elite passive income system for massive hourly earnings

---

## 🎮 Core Game Systems

### �️ **Treasure Hunting System**
- **Base Earnings**: 500-5,000 IDR per treasure (updated from old 1K-10K)
- **Treasure Capacity**: Starts at 20, upgradeable with Treasure Multiplier
- **Regeneration**: +5 treasure every 60 minutes (improvable with Fast Recovery)
- **Auto-Click**: Unlocks at Level 2 for automated treasure opening
- **Treasure Rarity**: 8 tiers from Common to Celestial affecting random box chances

### 🌙☀️ **Day/Night Risk System (GMT+7 Timezone)**
- **🌅 Day Mode (6 AM - 6 PM)**: Safe treasure opening with normal rewards
- **🌙 Night Mode (6 PM - 6 AM)**: High-risk, high-reward system:
  - **25%** chance to lose money in darkness
  - **25%** chance for 1.5x bonus earnings
  - **5%** chance to discover rare treasures (5-6x value)
  - **45%** chance for normal earnings

### ⚡ **Level & Experience System**
- **Experience Sources**: Treasure hunting, gambling, rare treasures (double XP)
- **Level Benefits**: Unlock Auto-Click (Lv2), Classes (Lv4), Advanced Classes (Lv8)
- **Progressive Unlocks**: New features and higher upgrade caps at each level

### 🎭 **Class System (7 Unique Classes)**

#### **Basic Classes (Level 4)**
- **🗝️ Treasure Hunter**: 15% chance for free treasure attempts
- **💼 Proud Merchant**: 20% bonus money earnings
- **🎰 Fortune Gambler**: 15% double chance, 8% lose everything chance  
- **🌙 Moon Guardian**: 20% random box chance during night hours
- **☀️ Day Breaker**: 20% random box chance during day hours
- **📦 Box Collector**: 10% chance for double random boxes
- **📜 Divine Scholar**: 10% bonus experience from treasures

#### **Advanced Classes (Level 8)**
- Enhanced versions with 25-30% abilities instead of 15-20%
- **Master Treasure Hunter**, **Elite Merchant**, **Fortune Master**, etc.

### 🛡️ **PvP & Defense Systems**

#### **🗡️ Auto Steal (Offensive)**
- **Success Rate**: 5% per level (max 25% at Level 5)
- **Automatic**: Triggers when you earn money, attempts to steal from random players
- **Steal Amount**: 1-5% of target's money based on your level
- **Lucky Strikes**: Can double stolen amounts with luck bonuses

#### **🛡️ Defense Mechanisms**
- **Shield Protection**: 3-hour invincibility from all theft (IDR 10,000)
- **Counter-Attack**: 20% chance per level to steal back when attacked
- **Intimidation**: Reduces others' steal success rates against you by 2% per level
- **Fast Recovery**: Reduces treasure regeneration time (60min → 30min at max)

### 🎰 **Gambling Hall Features**
- **Coin Flip Games**: Bet money on heads/tails with customizable amounts
- **Min/Mid/Max Betting**: Smart betting buttons based on your wealth
- **Treasure Fusion**: Combine treasures to create rare treasures (5-6x value)
- **Experience Rewards**: Gain 10 XP per gambling game

### 📦 **Inventory & Random Box System**
- **Random Box Sources**: Treasure rarity upgrades, class abilities, night bonuses
- **Reward Tiers**: Common, Rare, Legendary with escalating reward values
- **Box Contents**: Money, treasures, experience, shield protection, upgrade materials
- **Rarity Scaling**: Higher treasure rarity = better box drop chances

### 👑 **Prestige System (Elite Passive Income)**
- **Unlock Requirement**: High-level players with substantial wealth
- **Passive Rates**: 1-5% of total money earned per hour automatically
- **Prestige Levels**: 5 tiers with escalating costs and benefits
- **24/7 Earnings**: Massive passive income even when offline

### 🔄 **Automated Systems**
- **Hourly Treasure Regen**: +5 treasure every 60 minutes (faster with upgrades)
- **Hourly Auto Earning**: Passive income from Auto Earning upgrades
- **Daily Prize Distribution**: Richest player wins accumulated prize pool
- **Prestige Processing**: Elite hourly income for prestige players

---

## 🛠️ **Complete Upgrade System (15+ Upgrade Types)**

### **Core Upgrades**
- **🤖 Auto Earning (1-20)**: 0.05% passive income per level per hour
- **🗡️ Auto Steal (1-5)**: 5% success rate per level, auto-triggers on earnings
- **🗝️ Treasure Multiplier (1-10)**: +5 max treasure capacity + efficiency bonus per level
- **⚡ Lucky Strikes (1-5)**: 2% chance per level to double earnings/steals
- **🛡️ Shield Protection**: 3 hours of theft immunity (consumable)

### **Advanced Upgrades** 
- **🔄 Counter-Attack (1-5)**: 20% chance per level to steal back from attackers
- **😈 Intimidation (1-5)**: Reduce others' steal success by 2% per level
- **⚡ Fast Recovery (1-3)**: Reduce treasure regen from 60min to 30min
- **💎 Treasure Rarity (1-7)**: Unlock Common → Celestial treasure types
- **👑 Prestige System (1-5)**: Elite 1-5% hourly passive income

### 📊 **Game Economy & Balance**
- **Balanced Progression**: Upgrade costs scale exponentially with level
- **Multiple Strategies**: Pure earning, stealing, gambling, or hybrid approaches
- **Risk/Reward Balance**: Night mode offers high risk for high reward
- **Anti-Inflation**: Treasure limits and cooldowns prevent economy breaking
- **Competitive Dynamics**: Leaderboards and daily prizes drive engagement

---

## 🎯 Getting Started (Player Guide)

### **📝 Account Creation**
1. **Register** at `/register` with username, email, and password
2. **Verify** your account (if email verification enabled)
3. **Login** and access your dashboard immediately

### **🎮 First 10 Minutes**
1. **Open Your First Treasure**: Click "OPEN TREASURE" to earn your first IDR 100-2,000
2. **Check Your Stats**: View level, experience, and treasure count in the dashboard
3. **Understand Day/Night**: Note the current time mode and its effects
4. **Explore the Store**: See available upgrades but focus on earning first
5. **Reach Level 2**: Open treasures to gain XP and unlock Auto-Click feature

### **🚀 First Hour Strategy**
1. **Level 2 Achievement**: Unlock Auto-Click for automated treasure opening
2. **Earn 10K+ IDR**: Build initial capital through consistent treasure hunting
3. **First Upgrade**: Consider Auto Earning Level 1 for passive income
4. **Level 4 Goal**: Work towards class selection unlock
5. **Learn the Rhythm**: Understand treasure regeneration and timing

### **🏆 First Week Goals**
- **Reach Level 4+**: Unlock and choose your first class
- **50K+ IDR**: Build substantial wealth for major upgrades
- **Auto Steal Level 1**: Enter the PvP economy
- **Strategic Upgrades**: Focus on 2-3 upgrade types rather than spreading thin
- **Night Mode Experimentation**: Try risky night treasures for rare rewards

---


## 📄 License & Legal

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

### **Third-Party Assets**
- **Bootstrap 5**: MIT License
- **Font Awesome**: Font Awesome Free License
- **Laravel Framework**: MIT License

---

## 🎮 Start Your Adventure

### **🏆 What Awaits You**
- **🗝️ Treasure Hunting**: Open treasures and discover rare rewards
- **⚡ Level Progression**: Gain experience and unlock powerful features  
- **🎭 Class Mastery**: Choose from 7 unique classes with special abilities
- **🛡️ PvP Combat**: Engage in strategic stealing and defense mechanics
- **🎰 Risk & Reward**: Master the day/night cycle for maximum profits
- **👑 Elite Status**: Achieve prestige levels for massive passive income

### **💡 Pro Tips for New Players**
- **Start Conservative**: Focus on day-time treasure hunting until you build defenses
- **Level First**: Prioritize experience gains to unlock Auto-Click at Level 2
- **Choose Wisely**: Your Level 4 class selection significantly impacts your playstyle
- **Time Zones Matter**: GMT+7 night mode (6 PM - 6 AM) offers high-risk, high-reward gameplay
- **Community**: Learn from the leaderboard and observe successful player strategies

---

**⚡ The adventure begins now. Will you rise to become the ultimate Kazoku champion? ⚡**

## 🎮 Advanced Game Mechanics

### **Earning & Economy System**
| Action | Base Amount | Frequency | Special Features |
|--------|-------------|-----------|------------------|
| Treasure Hunting | 500–5,000 IDR | Per treasure | Class bonuses, Lucky Strikes 2x, Night risks |
| Auto Earning (Lv1-20) | 0.05-1.0% per hour | Hourly | Works offline, no treasure required |
| Auto Steal (Lv1-5) | 1-5% of target's money | Auto-trigger | Intimidation resistance, Counter-attacks |
| Gambling (Coin Flip) | Custom bet amounts | Manual | 10 XP per game, 50/50 odds |
| Rare Treasures | 5–6x normal (2,500–30,000) | From night mode/fusion | Double XP, class bonuses apply |
| Prestige Income | 1-5% per hour | Elite system | Massive passive income for veterans |

### **Comprehensive Upgrade Costs**
| Upgrade Type | Base Cost | Max Level | Scaling | Special Notes |
|--------------|-----------|-----------|---------|---------------|
| Auto Steal | IDR 10K | Level 5 | Linear (10K × level) | PvP core mechanic |
| Auto Earning | IDR 10K | Level 20 | Linear (10K × level) | Passive income foundation |
| Treasure Multiplier | IDR 15K | Level 10 | Linear (15K × level) | +5 capacity + efficiency |
| Lucky Strikes | IDR 15K | Level 5 | Linear (15K × level) | 2% chance per level to double |
| Counter-Attack | IDR 40K | Level 5 | Linear (40K × level) | 20% steal-back chance per level |
| Intimidation | IDR 20K | Level 5 | Linear (20K × level) | -2% enemy success per level |
| Fast Recovery | IDR 20K | Level 3 | Linear (20K × level) | 60min → 30min treasure regen |
| Treasure Rarity | IDR 20K | Level 7 | Linear (20K × level) | Better random box chances |
| Shield Protection | IDR 10K | Consumable | Fixed | 3 hours PvP immunity |
| Prestige System | IDR 100K+ | Level 5 | Exponential | Elite passive income unlock |

### **Class System Bonuses**
| Class | Basic Ability (Lv4) | Advanced Ability (Lv8) |
|-------|---------------------|-------------------------|
| 🗝️ Treasure Hunter | 15% free treasure attempts | 25% free treasure attempts |
| 💼 Proud Merchant | +20% money earnings | +30% money earnings |
| 🎰 Fortune Gambler | 15% double, 8% lose all | 25% double, 12% lose all |
| 🌙 Moon Guardian | 20% night random boxes | 30% night random boxes |
| ☀️ Day Breaker | 20% day random boxes | 30% day random boxes |
| 📦 Box Collector | 10% double boxes | 15% double boxes |
| 📜 Divine Scholar | +10% experience | +20% experience |

### **Day/Night Strategy Matrix**
| Time Period | Risk Level | Recommended Players | Key Benefits |
|-------------|------------|-------------------|--------------|
| **🌅 Day (6AM-6PM GMT+7)** | Safe | New players, conservatives | Guaranteed normal earnings, safe grinding |
| **🌙 Night (6PM-6AM GMT+7)** | High Risk/Reward | Risk-takers, advanced players | 25% bonus chance, 5% rare treasures |

---

## 🎯 Advanced Strategy Guide

### **🟢 Early Game (Levels 1-3, 0-50K IDR)**
**Priority Goals**: Level up fast, unlock Auto-Click at Level 2
1. **Focus on treasure hunting** to gain experience and build capital
2. **Purchase Auto Earning Level 1-2** for passive income foundation
3. **Avoid night mode** until you have defensive upgrades
4. **Save for Level 4** to unlock class selection

### **🟡 Mid Game (Levels 4-7, 50K-500K IDR)**
**Priority Goals**: Choose class, establish PvP presence, build upgrade foundation
1. **Select optimal class** based on playstyle:
   - **Conservative**: Treasure Hunter (free attempts) or Proud Merchant (bonus earnings)
   - **Aggressive**: Fortune Gambler (high risk/reward) or Day/Moon Guardian (boxes)
   - **Balanced**: Box Collector or Divine Scholar (experience focus)
2. **Purchase Auto Steal Level 1** to participate in PvP economy
3. **Invest in Treasure Multiplier** for increased capacity and efficiency
4. **Consider Shield Protection** when holding large amounts of money

### **🔴 Late Game (Level 8+, 500K+ IDR)**
**Priority Goals**: Advanced class, max key upgrades, prestige preparation
1. **Advance your class** at Level 8 for enhanced abilities
2. **Maximize core upgrades**: Auto Steal (5), Auto Earning (15-20), Lucky Strikes (5)
3. **Strategic night mode gameplay** for rare treasure acquisition
4. **PvP optimization**: Balance Counter-Attack and Intimidation based on threat level
5. **Prestige system preparation**: Accumulate wealth for elite passive income access

### **🏆 Endgame (Prestige System)**
**Priority Goals**: Elite passive income, leaderboard domination
1. **Prestige Level investment** for 1-5% hourly passive income
2. **Class mastery** with advanced abilities and perfect upgrade combinations
3. **Market timing** for night mode rare treasure farming
4. **Competitive positioning** for daily prize pool victories

### **💡 Advanced Tips**
- **Time Zone Advantage**: GMT+7 night mode (6 PM - 6 AM) offers rare treasure opportunities
- **Class Synergy**: Combine Proud Merchant earnings with Lucky Strikes for maximum profit
- **PvP Defense**: Intimidation + Counter-Attack creates powerful theft deterrent
- **Random Box Optimization**: High treasure rarity + Box Collector class = consistent bonus rewards
- **Prestige Timing**: Calculate optimal wealth threshold before investing in prestige system

---

## 📱 User Interface & Experience

### **🎮 Game Dashboard (Main Hub)**
- **Real-time Statistics**: Money, level, XP progress, treasure count with live updates
- **Time-based Indicators**: Dynamic day/night mode display with risk percentages
- **Auto-Click System**: Toggle automation for treasure opening (unlocks at Level 2)
- **Class Status**: Current class abilities and bonuses prominently displayed
- **Quick Actions**: Treasure opening, rare treasure access, status checking

### **🏪 Enhanced Store System**
- **15+ Upgrade Categories**: Complete upgrade tree with costs, benefits, and previews
- **Smart Pricing Display**: Shows current level, next level cost, and percentage benefits
- **Purchase Validation**: Prevents invalid purchases and provides clear error messaging
- **Prestige Section**: Elite passive income system for high-level players
- **Shield Protection**: Consumable PvP immunity system

### **📊 Advanced Leaderboard**
- **Top 10 Rankings**: Richest players with detailed ability breakdowns
- **Competitive Intelligence**: See other players' class selections and upgrade levels
- **Global Statistics**: Total players, accumulated wealth, prize pool status
- **Personal Analytics**: Your ranking, wealth percentile, and progression metrics

### **🎰 Gambling Hall**
- **Coin Flip Games**: Customizable betting with min/mid/max smart buttons
- **Treasure Fusion System**: Combine normal treasures to create rare treasures
- **Experience Rewards**: 10 XP per gambling session for level progression
- **Risk Management**: Betting limits and validation systems

### **📦 Inventory Management**
- **Random Box System**: Open boxes for money, treasures, experience, and special items
- **Item Categories**: Shields, upgrade materials, rare treasures, and consumables
- **Reward Tiers**: Common, Rare, Legendary boxes with escalating rewards
- **Usage Tracking**: History of opened boxes and received rewards

### **📈 Player Status & Analytics**
- **Level Progression**: Experience bar, next level requirements, and unlock previews
- **Upgrade Overview**: Visual representation of all 15+ upgrade levels
- **Class Information**: Detailed class abilities, bonuses, and advancement options
- **Activity Logs**: Complete history of treasure openings, PvP interactions, and earnings

---

## 🔧 Advanced Development Features

### **🔒 Security & Anti-Cheat**
- **Multi-layer Authentication**: Required for all game actions and sensitive operations
- **Rate Limiting**: Treasure opening cooldowns, purchase validation, spam prevention
- **Input Sanitization**: Comprehensive validation for all user inputs and transactions
- **Session Security**: Secure session management with automatic cleanup
- **Audit Logging**: Complete player action history for moderation and debugging

### **⚡ Performance & Optimization**
- **Database Efficiency**: Optimized queries with proper indexing and relationship loading
- **Caching System**: Strategic use of Laravel cache for frequently accessed data
- **AJAX Integration**: Seamless treasure opening and real-time updates without page reloads
- **Mobile Responsive**: Optimized UI for all device sizes with touch-friendly controls
- **Asset Optimization**: Minimized CSS/JS with efficient loading strategies

### **🛠️ Maintainability & Architecture**
- **Service Layer**: ExperienceService and other business logic abstraction
- **Event-Driven Design**: Proper separation between game mechanics and presentation
- **Modular Components**: Reusable UI components and game mechanics
- **Configuration Management**: Easy adjustment of game constants and balance parameters
- **Multilingual Support**: Complete EN/ID translation system for global accessibility
- **Automated Testing**: Comprehensive test coverage for critical game mechanics

### **📊 Analytics & Monitoring**
- **Player Behavior Tracking**: Comprehensive logging of all player actions and decisions
- **Economy Monitoring**: Real-time tracking of money flow, upgrade purchases, and prize pools
- **Balance Analytics**: Data-driven insights for game balance adjustments
- **Performance Metrics**: System performance monitoring and optimization opportunities

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**May the best earner win! 💰**
