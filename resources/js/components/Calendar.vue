<template>
  <div class="calendar">
    <div class="calendar-header">
      <button @click="previousMonth">Prev</button>
      <h2>{{ currentMonth }}</h2>
      <button @click="nextMonth">Next</button>
    </div>
    <div class="calendar-grid">
      <div v-for="day in days" class="calendar-cell">
        {{ day }}
      </div>

      <div
        v-for="date in dates"
        class="calendar-cell"
        :class="{
          'calendar-cell--today': isToday(date.value),
          'calendar-cell--selected': isSelected(date.value),
          'calendar-cell--disabled': date.isBeforeToday
        }"
        @click="!date.isBeforeToday && (isSelected(date.value) ? hideMenu() : showMenu(date.value))"
      >
        {{ date.value.date() }}
        <div v-if="menuVisible && !date.isBeforeToday && getAvailableTimes(selectedDate)" class="time-menu">
          <p class="disponible tipograpi">Disponible</p>
          <div
            v-for="time in getAvailableTimes(selectedDate)"
            :key="time"
            class="time-option"
            @click="selectDate(selectedDate, time); sendAppointment(selectedDate,time)"
          >
            {{ time }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dayjs from 'dayjs';
export default {
name: 'Calendar',
data() {
return {
selectedDate: dayjs(),
selectedTime: null,
currentDate: dayjs(),
//dates almacena el valor de las fechas dentro de generateCalendar()
dates: [],

days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
availableTimes: {
  '2023-04-28': ['08:00','10:00', '11:00', '12:00'],
  '2023-04-29': ['9:00', '10:00', '11:00', '12:00', '14:00'],
  '2023-04-30': ['13:00', '14:00', '15:00'],
  '2023-05-01': ['11:00', '12:00', '13:00', '14:00', '15:00', '16:00'],
  '2023-05-02': ['9:00', '11:00', '13:00', '15:00', '16:00', '18:00'],
  '2023-05-03': ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'],
},

menuVisible: false,
}
},
computed: {
currentMonth() {
return this.currentDate.format('MMMM YYYY');
}
},
methods: {
  generateCalendar() {
  const startOfMonth = this.currentDate.startOf('month');
  const endOfMonth = this.currentDate.endOf('month');
  const startDate = startOfMonth.startOf('week');
  const endDate = endOfMonth.endOf('week');
  const dates = [];
  let currentDate = startDate;
  const today = dayjs(); // Agrega esta línea para obtener la fecha actual
  while (currentDate.isBefore(endDate)) {
    // Agrega estas dos líneas para verificar si la fecha es anterior a la fecha actual
    const isBeforeToday = currentDate.isBefore(today, 'day');
    const date = { value: dayjs(currentDate), isBeforeToday };
    dates.push(date);
    currentDate = currentDate.add(1, 'day');
  }
  this.dates = dates;
},

isToday(date) {
return date.isSame(dayjs(), 'day');
},
isSelected(date) {
  return this.selectedDate && this.selectedDate.isSame(date, 'day');
},
selectDate(date, time) {
this.selectedDate = date;
this.selectedTime = time || null;
this.$emit('select-date', { date, time });
},
getAvailableTimes(date) {
return this.availableTimes[date.format('YYYY-MM-DD')];
},
previousMonth() {
this.currentDate = this.currentDate.subtract(1, 'month');
this.generateCalendar();
},
nextMonth() {
this.currentDate = this.currentDate.add(1, 'month');
this.generateCalendar();
},    
showMenu(date) {
  if(date)
  this.selectedDate = date;
  this.menuVisible = true;
},
hideMenu() {
  this.menuVisible = false;
  this.selectedDate = null;
}, 
 sendAppointment(date,time) {
  console.log( this.selectedDate.format('YYYY-MM-DD'),
       this.selectedTime)
      this.$emit("capturarHoraFecha",date.format('YYYY-MM-DD'),time)


  },
},
mounted() {
this.generateCalendar();
}
}
</script>
<style>
.calendar {
  display: flex;
  flex-direction: column;
  font-family: sans-serif;
  background-color: #fff;
  box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;

}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  background-color: #007aff;
  color: #fff;
}

.calendar-header button {
  background-color: transparent;
  color: #fff;
  border: none;
  outline: none;
  font-size: 16px;
  cursor: pointer;
}

.calendar-header h2 {
  margin: 0;
  font-size: 24px;
}

.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  grid-auto-rows: 50px;
  gap: 8px;
  padding: 12px;
}

.calendar-cell {
  display: flex;
  justify-content: center;
  align-items: center;
  border: none;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
}

.calendar-cell:hover {
  background-color: #f5f5f5;
}

.calendar-cell--today {
  background-color: #007aff;
  color: #fff;
}

.calendar-cell--selected {
  background-color: #fff;
  color: #007aff;
  border: 1px solid #007aff;
}

.calendar-cell--disabled {
  color: #999;
  pointer-events: none;
  background-color: #f5f5f5;
}

.time-menu {
  max-height: 200px; /* altura máxima del div */
  overflow-y: auto; /* agregar scroll vertical */
  position: absolute;
  top: calc(40% + 4px);
  left: 62%;
  transform: translateX(-50%);
  background-color: #fff;
  box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  padding: 12px;
  z-index: 1;
}

.time-option {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 36px;
  padding: 8px;
  margin: 4px;
  background-color: #f5f5f5;
  border-radius: 8px;
  color: #000000;
  font-weight: Roboto;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
  border: 1px solid #007aff;
}

.time-option:hover {
  background-color: #007aff;
  color: #fff;
}
.disponible{
  padding-bottom: 4px;
}
.unavailable{
  opacity: 0; /* establece el menú en una posición oculta */
  transition: opacity 0.3s ease-in-out;
  animation-name: cerrar-menu; /* nombre de la animación */
  animation-duration: 4s; /* duración de la animación */

}

@keyframes cerrar-menu {
  0% {
    opacity: 1; /* establece la propiedad inicial */
  }
  100% {
    opacity: 0; /* establece la propiedad final */
  }
}
</style>
