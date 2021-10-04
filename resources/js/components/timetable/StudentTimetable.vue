<template>
    <div class="clearfix">
        <div class="card">
            <div class="card-body">
                <div class="row static-header" id="tt-header">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        <strong>Date</strong>
                                    </div>
                                    <div class="col-md-11 hours-row" id="hours-row">
                                        <resize-observer @notify="onWindowResize"/>
                                        <div class="hour-slot" v-for="time in hourSlots">
                                            <strong>{{time}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" v-for="(record, recordIndex) in uiRecords">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="date-text">
                                            <strong>{{record.date}}</strong>
                                        </div>
                                        <div class="day-text">
                                            <strong>{{record.weekDay}}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-11 module-slot-row-container">
                                        <div class="module-slot-row" v-for="(row, rowIndex) in record.rows">
                                            <div v-for="(slot, slotIndex) in row" class="module-slot" v-bind:id="'ms-'+recordIndex+'-'+rowIndex+'-'+slotIndex">
                                                <div class="filled-slot" v-if="!slot.empty">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <strong>Subject:</strong>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    {{slot.module.module_name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <strong>Start Time:</strong>
                                                            {{slot.start_time}}
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <strong>End Time:</strong>
                                                            {{slot.end_time}}
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <strong>Type:</strong>
                                                            <span v-if="slot.deliveryModeSpecial.id&&slot.deliveryModeSpecial.id!=''">{{slot.deliveryModeSpecial.name}}</span>
                                                            <span v-else>{{slot.deliveryMode.name}}</span>
                                                        </div>
                                                        <div class="col-md-12 mb-2" v-if="slot.examType.name && slot.examType.name !== ''">
                                                            <strong>Exam Type</strong>
                                                            {{slot.examType.name}}
                                                        </div>
                                                        <div class="col-md-12 mb-2" v-if="slot.examCategory.name && slot.examCategory.name !== ''">
                                                            <strong>Exam Category</strong>
                                                            {{slot.examCategory.name}}
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <strong>Lecturer(s)</strong>
                                                            <div class="row mb-2" v-for="lecturer in slot.lecturers">
                                                                <div class="col-md-12">
                                                                    {{lecturer.name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-2">
                                                            <strong>Lecture Hall(s)</strong>
                                                            <div class="row mb-2" v-for="space in slot.spaces">
                                                                <div class="col-md-12">
                                                                    {{space.space_name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="empty-slot" v-if="slot.empty"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ResizeObserver} from 'vue-resize'
export default {
    name: "StudentTimetable",
    components:{
        ResizeObserver,
    },
    data() {
        return {
            records:[],
            uiRecords:[],
            hourSlots:[],
            minStartTime:"08:00 AM",
            maxEndTime:"06:00 PM",
            slotWidth:100,
            slotMinutes:30,
            uiFinalized:false,
            initialLoadDone:false,
            actionButtons:[],
            cancelSlot:[],
            cancelSlotRecordIndex:-1,
            cancelSlotRowIndex:-1,
            cancelSlotIndex:-1,
            cancelRequest:[]
        }
    },
    updated() {
        if (!this.uiFinalized) {
            this.setHourSlotWidth();
            this.finalizeUI();
        }

        if (this.uiFinalized) {
            this.initialLoadDone = true;
        }

        makeStickyHeader("tt-header");
    },
    methods: {
        prepareButtons(buttons) {
            let obj = this;
            if (buttons.length > 0) {
                buttons.forEach(function (button) {

                    obj.actionButtons.push(button);
                });
            }
        },
        triggerButtonCallBack(callBack, recordIndex, rowIndex, slotIndex) {
            let slot = this.records[recordIndex].rows[rowIndex][slotIndex];
            if (typeof window[callBack] === 'function') {

                let callBackArgs = [];
                callBackArgs.push(slot);

                window[callBack].apply(undefined, callBackArgs)
            }
        },
        onWindowResize() {
            if (this.initialLoadDone) {
                this.uiFinalized = false;
                this.setDimensions();
            }
        },
        finalizeUI() {
            let obj = this;
            let records = obj.records;

            if (records.length > 0) {
                records.forEach(function (record, recordIndex) {

                    if (record.rows && record.rows.length > 0) {
                        record.rows.forEach(function (row, rowIndex) {

                            if (row.length > 0) {
                                row.forEach(function (slot, slotIndex) {

                                    obj.setSlotStyle(recordIndex, rowIndex, slotIndex, slot)
                                });
                            }
                        });
                    }
                });
                this.uiFinalized = true;
            }
        },
        pushData(data) {
            if (data.timetable) {
                let timetable = data.timetable;
                this.minStartTime = timetable.minStartTime;
                this.maxEndTime = timetable.maxEndTime;
                this.records = timetable.records;
            }

            if (data.buttons && data.buttons.length > 0) {
                this.prepareButtons(data.buttons);
            }

            this.setDimensions();
            this.prepareUIRecords();
            this.uiFinalized = false;
        },
        prepareUIRecords() {
            let obj = this;
            let uiRecords = [];
            let records = obj.records;

            if (records.length > 0) {
                records.forEach(function (record) {

                    record.rows = obj.buildRows(record.slots);

                    uiRecords.push(record);
                });
            }

            obj.uiRecords = uiRecords;
        },
        buildRows(slots = [], rows = []) {
            let obj = this;
            if (slots.length > 0) {
                let rowSlots = [];
                let restSlots = [];
                let takenSlots = [];
                slots.forEach(function (slot) {

                    let startTime = slot.start_time;
                    let endTime = slot.end_time;

                    if (obj.hasTaken(startTime, endTime, takenSlots)) {
                        restSlots.push(slot);
                    } else {
                        rowSlots.push(slot);

                        let takenSlot = {};
                        takenSlot.startTime = startTime;
                        takenSlot.endTime = endTime;
                        takenSlots.push(takenSlot);
                    }
                });

                if (rowSlots.length > 0) {
                    let row = [];
                    let minStartTime = this.minStartTime;
                    let maxEndTime = this.maxEndTime;
                    let currStartTime = minStartTime;
                    let currEndTime = currStartTime;

                    rowSlots.forEach(function (slot) {

                        let startTime = slot.start_time;
                        let endTime = slot.end_time;

                        if (currStartTime !== startTime) {
                            if (startTime !== currEndTime) {
                                let emptySlot = {};
                                emptySlot.startTime = currStartTime;
                                emptySlot.endTime = startTime;
                                emptySlot.empty = true;
                                emptySlot.width = obj.getSlotWidth(emptySlot.startTime, emptySlot.endTime);

                                row.push(emptySlot);
                            }
                        }
                        currStartTime = endTime;
                        currEndTime = currStartTime;

                        slot.empty = false;
                        slot.width = obj.getSlotWidth(startTime, endTime);

                        row.push(slot);
                    });

                    if (currStartTime !== maxEndTime) {
                        let attendance = {};
                        attendance.student = 0;
                        attendance.lecturer = 0;

                        let emptySlot = {};
                        emptySlot.startTime = currStartTime;
                        emptySlot.endTime = maxEndTime;
                        emptySlot.empty = true;
                        emptySlot.width = obj.getSlotWidth(emptySlot.startTime, emptySlot.endTime);
                        emptySlot.attendance = attendance;

                        row.push(emptySlot);
                    }

                    rows.push(row);
                }

                if (restSlots.length > 0) {
                    rows = obj.buildRows(restSlots, rows);
                }
            }

            return rows;
        },
        hasTaken(startTime, endTime, takenSlots) {

            let obj = this;
            let taken = false;
            if (takenSlots.length > 0) {

                let formatTFHF = obj.getStartEndDateObj(startTime, endTime);

                startTime = formatTFHF.startTime;
                endTime = formatTFHF.endTime;
                let startTS = startTime.getTime();
                let endTS = endTime.getTime();

                takenSlots.forEach(function (takenSlot) {

                    let slotStart = takenSlot.startTime;
                    let slotEnd = takenSlot.endTime;

                    let formatTFHF = obj.getStartEndDateObj(slotStart, slotEnd);

                    slotStart = formatTFHF.startTime;
                    slotEnd = formatTFHF.endTime;

                    let slotStartTs = slotStart.getTime();
                    let slotEndTs = slotEnd.getTime();

                    if (slotStartTs <= startTS && startTS < slotEndTs) {
                        taken = true;
                        return false;
                    } else if (slotStartTs < endTS && endTS <= slotEndTs) {
                        taken = true;
                        return false;
                    } else if (startTS <= slotStartTs && slotStartTs < endTS) {
                        taken = true;
                        return false;
                    } else if (startTS < slotEndTs && slotEndTs <= endTS) {
                        taken = true;
                        return false;
                    }
                });
            }

            return taken;
        },
        setDimensions() {
            let hourRowWidth = document.getElementById("hours-row").offsetWidth;

            let singleSlotSecs = this.slotMinutes * 60;

            let startTime = this.minStartTime;
            let endTime = this.maxEndTime;

            if (startTime !== "" && endTime !== "") {

                let formatTFHF = this.getStartEndDateObj(startTime, endTime);

                startTime = formatTFHF.startTime;
                endTime = formatTFHF.endTime;

                let secondsDiff = (endTime.getTime() - startTime.getTime()) / 1000;

                let slotsCount = secondsDiff / singleSlotSecs;

                this.setHourSlots(startTime.getTime() / 1000, slotsCount);
                let slotWidth = hourRowWidth / slotsCount;
                this.slotWidth = parseInt(slotWidth + "");
            }
        },
        setHourSlots(startTS, slotsCount) {
            let singleSlotSecs = this.slotMinutes * 60;
            let hourSlots = [];

            if (slotsCount > 0) {
                let currTS = startTS;
                for (let i = 1; i <= slotsCount; i++) {
                    let time = this.getTimeForTimestamp(currTS);
                    currTS += singleSlotSecs;

                    hourSlots.push(time);
                }
            }

            this.hourSlots = hourSlots;
        },
        getTimeForTimestamp(timestamp) {
            let date = new Date(timestamp * 1000);
            let hour = date.getHours();
            let minutes = "0" + date.getMinutes();
            let ampm = "AM";

            if (hour > 12) {
                hour = hour - 12;
                ampm = 'PM';
            } else if (hour === 12) {
                hour = 12;
                ampm = 'PM';
            } else if (hour === 0) {
                hour = 12;
            }

            return hour + ":" + minutes.substr(-2) + " " + ampm;
        },
        getSlotWidth(startTime, endTime) {

            let width = 0;
            if (startTime !== "" && endTime !== "") {

                let formatTFHF = this.getStartEndDateObj(startTime, endTime);

                startTime = formatTFHF.startTime;
                endTime = formatTFHF.endTime;

                let secondsDiff = (endTime.getTime() - startTime.getTime()) / 1000;
                let singleSlotSecs = this.slotMinutes * 60;
                let slotCount = secondsDiff / singleSlotSecs;

                if (secondsDiff % singleSlotSecs !== 0) {
                    slotCount++;
                }

                width = slotCount * this.slotWidth;
            }

            return width;
        },
        getStartEndDateObj(startTime, endTime) {

            if (startTime !== "" && endTime !== "") {
                let startAMPM = "am";
                let startMinSplit = startTime.split(" ");
                if (startMinSplit.length === 2) {

                    startAMPM = startMinSplit[1].toLowerCase();
                }

                let endAMPM = "am";
                let endMinSplit = endTime.split(" ");
                if (endMinSplit.length === 2) {

                    endAMPM = endMinSplit[1].toLowerCase();
                }

                startTime = "2020-12-27 " + this.get24HourTime(startTime);
                startTime = new Date(startTime);

                if (startAMPM === "pm" && endAMPM === "am") {
                    //this is next day
                    endTime = "2020-12-28 " + this.get24HourTime(endTime);
                    endTime = new Date(endTime);
                } else {

                    endTime = "2020-12-27 " + this.get24HourTime(endTime);
                    endTime = new Date(endTime);
                }
            }

            return {"startTime": startTime, "endTime": endTime}
        },
        get24HourTime(time) {

            let data = "";
            if (time !== "") {

                let timeSplit = time.split(":");

                if (timeSplit.length === 2) {

                    let hour = parseInt(timeSplit[0]);

                    let minute = timeSplit[1];
                    let minSplit = minute.split(" ");

                    if (minSplit.length === 2) {

                        minute = parseInt(minSplit[0]);
                        let ampm = minSplit[1].toLowerCase();

                        if (hour < 12 && ampm === "pm") {

                            hour += 12;
                        }
                    }

                    data = hour + ":" + minute;
                }
            }

            return data;
        },
        setSlotStyle(recordIndex, rowIndex, slotIndex, slot) {
            let slotId = "ms-" + recordIndex + "-" + rowIndex + "-" + slotIndex;
            if (document.getElementById(slotId)) {
                let bgColor = "#FFFFFF";
                if (slot.module) {
                    if (slot.module.color) {
                        bgColor = slot.module.color;
                    }
                }
                let textColor = this.getTextColor(bgColor);

                document.getElementById(slotId).style.width = slot.width + "px";
                document.getElementById(slotId).style.backgroundColor = bgColor;
                document.getElementById(slotId).style.color = textColor;

                if (slot.slot_status === 3) {
                    document.getElementById(slotId).style.opacity = "0.5";
                }
            }
        },
        setHourSlotWidth() {
            let slotWidth = this.slotWidth;
            let elements = document.getElementsByClassName("hour-slot");

            for (let i = 0; i < elements.length; i++) {
                elements[i].style.width = slotWidth + "px";
            }
        },
        getTextColor(color) {
            let textColor = "#FFFFFF";
            let rgb = this.colorToRGB(color);

            if (rgb) {
                let brightness = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) / 1000);

                if (brightness > 125) {
                    textColor = "#222222";
                } else {
                    textColor = "#FFFFFF";
                }
            }

            return textColor;
        },
        colorToRGB(color) {
            if (!color) {
                return "";
            }
            if (color.toLowerCase() === 'transparent') {
                return [0, 0, 0, 0];
            }

            if (color[0] === '#') {
                if (color.length < 7) {
                    // convert #RGB and #RGBA to #RRGGBB and #RRGGBBAA
                    color = '#' + color[1] + color[1] + color[2] + color[2] + color[3] + color[3] + (color.length > 4 ? color[4] + color[4] : '');
                }
                return [parseInt(color.substr(1, 2), 16),
                    parseInt(color.substr(3, 2), 16),
                    parseInt(color.substr(5, 2), 16),
                    color.length > 7 ? parseInt(color.substr(7, 2), 16) / 255 : 1];
            }
            if (color.indexOf('rgb') === -1) {
                // convert named colors
                // intentionally use unknown tag to lower chances of css rule override with !important
                let tempElem = document.body.appendChild(document.createElement('whatever'));

                let flag = 'rgb(1, 2, 3)'; // this flag tested on chrome 59, ff 53, ie9, ie10, ie11, edge 14
                tempElem.style.color = flag;

                if (tempElem.style.color !== flag) {
                    return ""; // color set failed - some monstrous css rule is probably taking over the color of our object
                }
                tempElem.style.color = color;

                if (tempElem.style.color === flag || tempElem.style.color === '') {
                    return ""; // color parse failed
                }
                color = getComputedStyle(tempElem).color;
                document.body.removeChild(tempElem);
            }
            if (color.indexOf('rgb') === 0) {
                if (color.indexOf('rgba') === -1) {
                    color += ',1'; // convert 'rgb(R,G,B)' to 'rgb(R,G,B)A' which looks awful but will pass the regexp below
                }

                return color.match(/[\.\d]+/g).map(function (a) {
                    return +a
                });
            }

            return "";
        }
    }
}

</script>

<style scoped>
.hours-row {
    padding: 0;
    margin-bottom: 5px;
}

.hour-slot {
    float: left;
    width: 100px;
    height: auto;
    border: 1px solid #dedede;
    border-right-color: transparent;
    font-size: 14px;
    text-align: center;
    padding: 10px 0;
}

.hour-slot:last-child {
    border-right-color: #dedede;
}

.module-slot-row-container {
    padding: 0 !important;
}

.module-slot-row {
    clear: both;
    width: 100%;
    height: auto;
    margin-bottom: 15px;
}

.module-slot {
    float: left;
    width: 100px;
    height: auto;
    min-height: 1px;
    background-color: #5bc0de;
    color:#FFFFFF;
}

.filled-slot {
    clear: both;
    width: 100%;
    padding: 10px;
}

.empty-slot {
    clear: both;
    width: 100%;
}

.module-slot-row  {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display:         flex;
    flex-wrap: wrap;
}

.module-slot-row  > .module-slot {
    display: flex;
    flex-direction: column;
}

.static-header {
    position: relative;
    z-index: 999;
    top: 0;
}
</style>
