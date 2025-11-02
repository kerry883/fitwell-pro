# FitWell Pro - Entity Relationship Design Documentation

## Overview
This document explains the complete database design for FitWell Pro, a comprehensive fitness and nutrition client management platform for trainers and coaches.

---

## Table of Contents
1. [Core Design Principles](#core-design-principles)
2. [Entity Modules](#entity-modules)
3. [Key Relationships](#key-relationships)
4. [Design Patterns](#design-patterns)
5. [Implementation Notes](#implementation-notes)

---

## Core Design Principles

### 1. **Flexibility & Scalability**
- Support for both static and dynamic/progressive programs
- Dynamic scheduling supporting individual, group, recurring sessions
- Flexible payment models (one-time, subscription, per-session, per-program)

### 2. **Comprehensive Tracking**
- All client activities tracked (workouts, nutrition, videos, progress)
- Full audit trail with timestamps
- Status tracking for all major entities

### 3. **Communication Hub**
- Multi-channel notifications (email, SMS, push, in-app)
- Automated messaging system
- Thread-based messaging

### 4. **Business Intelligence Ready**
- Engagement metrics
- Business analytics
- Retention and revenue tracking

---

## Entity Modules

## 1. USER MANAGEMENT MODULE

### **USER** (Core entity)
Primary authentication and user information table.

**Key Fields:**
- `user_type`: ADMIN, TRAINER, CLIENT
- `status`: Controls account accessibility
- Stores basic contact and authentication info

**Design Decision:** Single user table with type discrimination rather than separate tables for each user type. This simplifies authentication and allows for role flexibility.

### **USER_ROLE**
Supports multiple roles per user with permission management.

**Why separate from USER?**
- A trainer might also be an admin
- Allows future role expansion
- Permission-based access control via JSON field

---

## 2. CLIENT PROFILE & HEALTH MODULE

### **CLIENT_PROFILE**
Extended profile information for clients.

**Key Features:**
- Timezone support for global clients
- JSON preferences for custom client settings
- Separate from USER for data organization

### **HEALTH_HISTORY**
Critical for safety and program customization.

**Important Fields:**
- `medical_clearance`: Legal protection
- `fitness_level`: Program difficulty matching
- `exercise_limitations`: Safety constraints

### **EMERGENCY_CONTACT**
One-to-many relationship (clients can have multiple contacts).

**Best Practice:** Always have `is_primary` flag for emergency situations.

### **CLIENT_GOAL**
Tracks multiple concurrent goals per client.

**Features:**
- Progress tracking (current_progress vs target_value)
- Status management (active, completed, paused)
- Target dates for accountability

### **FITNESS_ASSESSMENT**
Baseline and periodic assessments.

**Design Pattern:**
- Links to trainer who conducted it
- JSON fields for flexible assessment types
- Document storage for forms/reports

---

## 3. PROGRAM MANAGEMENT MODULE

### **PROGRAM_TEMPLATE**
Reusable program blueprints created by trainers.

**Key Distinction:**
- `is_progressive`: Determines if program auto-advances
- `phase_structure`: JSON for complex periodization
- Templates can be workout, nutrition, or hybrid

### **CLIENT_PROGRAM**
Instance of a template assigned to a specific client.

**Critical Fields:**
- `assignment_type`: STATIC vs DYNAMIC_PROGRESSIVE
- `current_week` & `current_phase`: Track progression
- `auto_advance`: Enable/disable automatic progression
- `customizations`: JSON for client-specific modifications

**Design Decision:** Separate template from assignment allows:
1. Multiple clients on same template
2. Individual customization without affecting template
3. Template updates don't break existing assignments

### **PROGRAM_PHASE**
Supports periodization (e.g., Hypertrophy → Strength → Power).

**Structure:**
- Linked to template, not client program
- Numbered phases with durations
- JSON goals for flexibility

---

## 4. EXERCISE LIBRARY MODULE

### **EXERCISE_CATEGORY**
Hierarchical categorization (parent-child relationship).

**Example Structure:**
```
Strength
  ├─ Upper Body
  │   ├─ Chest
  │   ├─ Back
  │   └─ Shoulders
  └─ Lower Body
      ├─ Quads
      └─ Hamstrings
```

### **EXERCISE**
Comprehensive exercise database.

**Features:**
- Trainer-created custom exercises (`is_custom` flag)
- Rich media (video demos, images)
- Equipment and muscle group tracking (JSON arrays)
- Exercise alternatives for substitutions

---

## 5. WORKOUT SESSION MODULE

### **WORKOUT_SESSION**
Individual workout within a program.

**Organization:**
- Links to both client_program and phase
- `week_number` and `day_number` for scheduling
- Supports rest days (`session_type`: REST)

### **SESSION_EXERCISE**
The actual exercises within a session.

**Flexible Prescription:**
- Supports multiple formats: sets/reps, duration, distance
- Superset grouping
- Tempo notation (JSON)
- Rest periods

**Design Choice:** Separate table allows:
1. Same exercise multiple times in a session
2. Different prescriptions per occurrence
3. Easy reordering

### **WORKOUT_COMPLETION**
Tracks when clients complete workouts.

**Accountability Features:**
- Status: COMPLETED, PARTIAL, SKIPPED
- Duration tracking
- Rating system for client feedback

### **EXERCISE_COMPLETION**
Granular tracking of each exercise performed.

**Purpose:**
- Progress tracking (weight progression, rep increases)
- Form check correlation with videos
- Performance analytics

---

## 6. NUTRITION MODULE

### **NUTRITION_PLAN**
Macro-based nutrition guidance.

**Structure:**
- Linked to client program
- Daily macro targets
- Meal timing and frequency (JSON)
- Dietary restrictions tracking

### **MEAL_PLAN**
Specific meal recommendations.

**Features:**
- Flexible meal types (including pre/post workout)
- Recipe storage
- Macro breakdown per meal
- Allergen tracking

### **NUTRITION_LOG**
Client food diary.

**Design Decision:** Separate from meal plan allows:
- Tracking adherence vs. prescribed
- Off-plan meals
- Photo documentation

---

## 7. VIDEO MANAGEMENT MODULE

### **VIDEO**
Central to form checking and progress documentation.

**Critical Relationships:**
- Links to specific workout session
- Links to specific exercise (for form checks)
- Client notes for context

**Review Workflow:**
```
PENDING → IN_REVIEW → REVIEWED/APPROVED/NEEDS_REVISION
```

### **VIDEO_FEEDBACK**
Trainer response to client videos.

**Multi-Format Feedback:**
- Written comments
- Video response URL (trainer records response)
- Rating system
- Exercise suggestions (JSON)
- Follow-up flag for serious issues

### **VIDEO_ANNOTATION**
Timestamped, positional feedback on videos.

**Use Case:** Trainer marks specific moment in video:
- "At 0:23, watch your knee alignment"
- Position data for video player integration

---

## 8. PROGRESS TRACKING MODULE

### **PROGRESS_ENTRY**
Umbrella entry for different progress types.

**Design Pattern:** One entry can have multiple related records:
- Measurement + Photos + Performance metrics all from same day

### **MEASUREMENT**
Body composition tracking.

**Features:**
- Weight trends
- Body fat percentage
- JSON for flexible measurements (chest, waist, arms, etc.)

### **PERFORMANCE_METRIC**
Strength, cardio, flexibility improvements.

**Flexibility:**
- Links to specific exercise
- Generic metric name/value/unit structure
- Tracks any performance measure

### **PROGRESS_PHOTO**
Visual progress documentation.

**Organization:**
- Multiple angle types (front, side, back)
- Links to progress entry for context
- Date-based comparison

---

## 9. SCHEDULING MODULE (DYNAMIC)

### **TRAINER_AVAILABILITY**
Defines when trainers are available.

**Features:**
- Day-of-week recurring windows
- Date-ranged effectiveness (vacations, seasons)
- Slot duration and buffer times
- Multiple availability windows per day

**Example:**
```
Monday: 6AM-12PM, 2PM-8PM (slot: 60min, buffer: 15min)
Tuesday: 8AM-6PM (slot: 30min, buffer: 10min)
```

### **APPOINTMENT**
Core scheduling entity - highly flexible.

**Supports:**
- Individual sessions
- Group sessions (via GROUP_SESSION)
- One-time or recurring
- Multiple statuses for workflow management

**Status Flow:**
```
SCHEDULED → CONFIRMED → COMPLETED
           ↓
        CANCELLED / RESCHEDULED / NO_SHOW
```

### **RECURRING_PATTERN**
Defines recurring appointment rules.

**Flexibility:**
- Multiple recurrence types (daily, weekly, biweekly, monthly)
- JSON rules for complex patterns (e.g., "every other Tuesday")
- Exception dates (skip holidays)
- End by date or occurrence count

**Example Rules:**
```json
{
  "pattern": "weekly",
  "days": ["MONDAY", "WEDNESDAY", "FRIDAY"],
  "time": "18:00",
  "duration_minutes": 60
}
```

### **GROUP_SESSION**
Group training/class functionality.

**Features:**
- Participant limits
- Per-person pricing
- Status management (open, full, cancelled)
- Links to main appointment

### **SESSION_PARTICIPANT**
Many-to-many relationship for group sessions.

**Tracking:**
- Registration vs actual attendance
- Individual participant notes
- Attendance history

### **APPOINTMENT_REMINDER**
Automated reminder system.

**Multi-channel:**
- Email, SMS, push notifications, in-app
- Configurable timing (minutes before)
- Sent status tracking

---

## 10. COMMUNICATION MODULE

### **MESSAGE_THREAD**
Conversation container.

**Types:**
- One-on-one (trainer-client)
- Group threads (multiple participants)
- Announcements (trainer to multiple clients)

### **MESSAGE**
Individual messages within threads.

**Features:**
- Attachment support (JSON array)
- Read receipts
- Timestamps for conversation flow

### **THREAD_PARTICIPANT**
Who's in each thread.

**Why Separate Table?**
- Supports group conversations
- Track join/leave times
- Mute/unmute functionality

### **NOTIFICATION**
In-app notification system.

**Polymorphic Design:**
- `entity_type` + `related_entity_id` links to any entity
- Supports videos, messages, appointments, workouts, etc.
- Type categorization for filtering/prioritization

### **NOTIFICATION_TEMPLATE**
Pre-defined message templates.

**Multi-Channel:**
- Email template
- SMS template
- Push notification template
- Template variables for personalization

**Example Variables:**
```json
{
  "client_name": "{{first_name}}",
  "workout_name": "{{session_name}}",
  "scheduled_time": "{{appointment_time}}"
}
```

### **AUTOMATED_MESSAGE**
Scheduled/triggered messages.

**Trigger Types:**
- Time-based (send at specific time)
- Event-based (after workout completion)
- Condition-based (client inactive for X days)

**Use Cases:**
- Welcome series for new clients
- Missed workout follow-ups
- Milestone celebrations
- Payment reminders

---

## 11. PAYMENT & SUBSCRIPTION MODULE

### **PACKAGE**
Service offerings defined by trainers.

**Flexible Types:**
- One-time (single program purchase)
- Subscription (monthly recurring)
- Per-session (pay-per-training)
- Per-program (buy full program)

**Features Included:** JSON for flexible package contents
```json
{
  "sessions_per_month": 8,
  "nutrition_plan": true,
  "form_checks": "unlimited",
  "messaging": true,
  "app_access": true
}
```

### **CLIENT_SUBSCRIPTION**
Active subscriptions for clients.

**Management:**
- Auto-renewal flag
- Next billing date
- Pause/cancel functionality
- Status tracking (active, paused, cancelled, expired)

**Design Decision:** Separate from payment to distinguish:
- Subscription (ongoing agreement)
- Payment (individual transaction)

### **PAYMENT**
Individual payment transactions.

**Polymorphic Relationships:**
- Can link to subscription (recurring payment)
- Can link to appointment (session payment)
- Can link to program (program purchase)
- Can be standalone (one-time payment)

**Complete Workflow:**
```
PENDING → COMPLETED
        ↓
     FAILED / REFUNDED / CANCELLED
```

### **INVOICE**
Detailed billing documentation.

**Professional Features:**
- Unique invoice numbers
- Line items (JSON for flexibility)
- Tax and discount handling
- Document generation URL
- Due date tracking for overdue alerts

**Status Workflow:**
```
DRAFT → SENT → PAID
             ↓
          OVERDUE
```

---

## 12. BUSINESS ANALYTICS MODULE

### **CLIENT_ENGAGEMENT**
Daily engagement metrics per client.

**Tracked Metrics:**
- Workouts completed
- Videos uploaded
- Messages sent
- Login frequency
- Completion rate
- Last activity timestamp

**Purpose:**
- Identify at-risk clients (low engagement)
- Measure program adherence
- Trigger interventions

### **BUSINESS_METRIC**
Aggregate business intelligence.

**Metric Types:**
- Retention rates
- Revenue tracking
- Attendance patterns
- Satisfaction scores
- Referral tracking

**JSON Details Field:** Flexible for metric-specific data
```json
{
  "retention": {
    "month": "2024-10",
    "retained_clients": 45,
    "churned_clients": 3,
    "new_clients": 8
  }
}
```

---

## Key Relationships

### One-to-One
- USER ↔ CLIENT_PROFILE
- USER ↔ HEALTH_HISTORY
- PAYMENT ↔ INVOICE
- APPOINTMENT ↔ GROUP_SESSION (optional)

### One-to-Many
- USER → CLIENT_GOAL (one client, multiple goals)
- PROGRAM_TEMPLATE → CLIENT_PROGRAM (one template, many assignments)
- CLIENT_PROGRAM → WORKOUT_SESSION (one program, many sessions)
- WORKOUT_SESSION → SESSION_EXERCISE (one session, many exercises)
- VIDEO → VIDEO_FEEDBACK (one video, multiple feedback entries)
- MESSAGE_THREAD → MESSAGE (one thread, many messages)
- PACKAGE → CLIENT_SUBSCRIPTION (one package, many subscribers)

### Many-to-Many
- EXERCISE ↔ SESSION_EXERCISE (via session)
- USER ↔ MESSAGE_THREAD (via THREAD_PARTICIPANT)
- GROUP_SESSION ↔ USER (via SESSION_PARTICIPANT)

### Polymorphic Relationships
- NOTIFICATION.related_entity_id (can reference any entity)
- PAYMENT (can link to subscription, appointment, or program)

---

## Design Patterns

### 1. **Soft Deletes**
Recommended addition to most tables:
```sql
deleted_at TIMESTAMP NULL
is_deleted BOOLEAN DEFAULT FALSE
```

### 2. **Audit Trail**
All major entities include:
- `created_at`
- `updated_at`
- `created_by` / `updated_by` (where applicable)

### 3. **Status Enums**
Clear state management:
- ACTIVE, INACTIVE, SUSPENDED
- PENDING, COMPLETED, CANCELLED
- Enables workflow tracking

### 4. **JSON for Flexibility**
Used for:
- `permissions` - Evolving permission system
- `preferences` - User-specific settings
- `customizations` - Client-specific program mods
- `line_items` - Invoice items
- `template_variables` - Dynamic content

### 5. **UUID Primary Keys**
- Better for distributed systems
- Security (non-sequential)
- Easier merging/migration

---

## Implementation Notes

### Indexing Strategy

**Priority Indexes:**
```sql
-- Authentication
USER(email)

-- Frequent Lookups
CLIENT_PROGRAM(client_id, status)
WORKOUT_SESSION(client_program_id, week_number)
VIDEO(client_id, review_status)
APPOINTMENT(trainer_id, scheduled_start)
PAYMENT(client_id, status)

-- Date Range Queries
MEASUREMENT(client_id, measurement_date)
NOTIFICATION(user_id, created_at)
MESSAGE(thread_id, sent_at)

-- Composite Indexes
SESSION_EXERCISE(session_id, exercise_order)
APPOINTMENT_REMINDER(appointment_id, is_sent)
```

### Constraints

**Foreign Key Cascades:**
- `ON DELETE CASCADE`: For dependent data (e.g., VIDEO_ANNOTATION on VIDEO_FEEDBACK)
- `ON DELETE SET NULL`: For references that should persist (e.g., EXERCISE in historical PERFORMANCE_METRIC)
- `ON DELETE RESTRICT`: For critical references (e.g., USER in PAYMENT)

**Unique Constraints:**
```sql
USER(email)
INVOICE(invoice_number)
```

**Check Constraints:**
```sql
PACKAGE: price >= 0
WORKOUT_SESSION: week_number > 0
SESSION_EXERCISE: sets > 0, reps > 0
APPOINTMENT: scheduled_end > scheduled_start
```

### Performance Considerations

**Large Tables (optimize early):**
- MESSAGE (high volume)
- NOTIFICATION (high volume)
- WORKOUT_COMPLETION (grows daily)
- PAYMENT (transaction history)
- CLIENT_ENGAGEMENT (daily records)

**Strategies:**
- Partitioning by date (MESSAGE, NOTIFICATION)
- Archival strategy for old data
- Read replicas for reporting
- Caching for frequently accessed data (USER, EXERCISE)

### Scalability Notes

**Horizontal Scaling:**
- UUID PKs facilitate sharding
- Consider sharding by trainer_id or client_id
- Avoid cross-shard JOINs in queries

**Vertical Scaling:**
- Separate read and write operations
- Use materialized views for analytics
- Consider separate analytics database

---

## Module Dependencies

```
USER (Core)
  └─> CLIENT_PROFILE
  └─> HEALTH_HISTORY
  └─> CLIENT_GOAL
       └─> PROGRAM_TEMPLATE
            └─> CLIENT_PROGRAM
                 └─> WORKOUT_SESSION
                 └─> NUTRITION_PLAN
       └─> APPOINTMENT
       └─> PAYMENT
            └─> INVOICE

EXERCISE (Independent Library)
  └─> SESSION_EXERCISE
  └─> PERFORMANCE_METRIC

VIDEO (Depends on WORKOUT_SESSION + EXERCISE)
  └─> VIDEO_FEEDBACK
       └─> VIDEO_ANNOTATION

COMMUNICATION (Depends on USER)
  └─> MESSAGE_THREAD
       └─> MESSAGE
  └─> NOTIFICATION
  └─> AUTOMATED_MESSAGE
```

---

## Future Enhancements

### Potential Additions:
1. **Multi-Trainer Support** (if needed later)
   - ORGANIZATION entity
   - TRAINER_CLIENT_RELATIONSHIP table

2. **Advanced Nutrition**
   - FOOD_DATABASE entity
   - RECIPE_INGREDIENT link table

3. **Client Portal Features**
   - RESOURCE_LIBRARY (documents, videos)
   - COMMUNITY_POST (client interactions)

4. **Advanced Analytics**
   - CLIENT_CHURN_PREDICTION
   - PROGRAM_EFFECTIVENESS_SCORE

5. **Integration Layer**
   - EXTERNAL_INTEGRATION entity
   - SYNC_LOG for third-party data

---

## Summary

This ERD design provides:
- ✅ Complete client management lifecycle
- ✅ Flexible program assignment (static & dynamic)
- ✅ Comprehensive tracking (workouts, nutrition, videos, progress)
- ✅ Dynamic scheduling (individual, group, recurring)
- ✅ Multi-channel communication
- ✅ Complete payment & subscription handling
- ✅ Business intelligence ready
- ✅ Scalable architecture

The design balances flexibility with structure, using JSON for evolving requirements while maintaining referential integrity for core relationships.
