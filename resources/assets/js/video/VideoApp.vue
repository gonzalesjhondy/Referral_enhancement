<script>
import axios from "axios";
import { Transition } from "vue";
import AgoraRTC from "agora-rtc-sdk-ng";
import PrescriptionModal from "./PrescriptionModal.vue";
import LabRequestModal from "./LabRequestModal.vue";

export default {
  name: "RecoApp",
  components: {
    PrescriptionModal,
    LabRequestModal,
  },
  data() {
    return {
      showTooltip: false,
      showPrescription: false,
      showUpward: false,
      showEndcall: false,
      showVedio: false,
      showMic: false,
      ringingPhoneUrl: $("#broadcasting_url").val() + "/public/ringing.mp3",
      baseUrl: $("#broadcasting_url").val(),
      doctorUrl:
        $("#broadcasting_url").val() + "/resources/img/video/Doctor5.png",
      doctorUrl1:
        $("#broadcasting_url").val() + "/resources/img/video/Doctor6.png",
      declineUrl:
        $("#broadcasting_url").val() + "/resources/img/video/decline.png",
      videoCallUrl:
        $("#broadcasting_url").val() + "/resources/img/video/videocall.png",
      micUrl: $("#broadcasting_url").val() + "/resources/img/video/mic.png",
      dohLogoUrl:
        $("#broadcasting_url").val() + "/resources/img/video/doh-logo.png",
      tracking_id: this.getUrlVars()["id"],
      referral_code: this.getUrlVars()["code"],
      referring_md: this.getUrlVars()["referring_md"],
      activity_id: this.getUrlVars()["activity_id"],
      options: {
        // Pass your App ID here.
        appId: "0fc02f6b7ce04fbcb1991d71df2dbe0d",
        // Set the channel name.
        channel: this.getUrlVars()["code"],
        // Pass your temp token here.
        token: null,
      },

      form: {},
      patient_age: "",
      file_path: [],
      file_name: [],
      icd: [],

      videoStreaming: true,
      audioStreaming: true,
      channelParameters: {
        // A variable to hold a local audio track.
        localAudioTrack: null,
        // A variable to hold a local video track.
        localVideoTrack: null,
        // A variable to hold a remote audio track.
        remoteAudioTrack: null,
        // A variable to hold a remote video track.
        remoteVideoTrack: null,
        // A variable to hold the remote user id.s
        remoteUid: null,
      },
      showDiv: false,
      form_type: "normal",
    };
  },
  mounted() {
    axios
      .get(
        `${this.baseUrl}/doctor/referral/video/normal/form/${this.tracking_id}`
      )
      .then((res) => {
        const response = res.data;
        console.log(response);
        this.form = response.form;
        if (response.age_type === "y")
          this.patient_age = response.patient_age + " Years Old";
        else if (response.age_type === "m")
          this.patient_age = response.patient_age + " Months Old";

        this.icd = response.icd;
        console.log("testing\n" + this.icd);

        this.file_path = response.file_path;
        this.file_name = response.file_name;

        console.log(response);
      })
      .catch((error) => {
        console.log(error);
      });

    //this.hideDivAfterTimeout();
    window.addEventListener("click", this.showDivAgain);
  },
  beforeUnmount() {
    window.removeEventListener("click", this.showDivAgain);
  },
  props: ["user"],
  created() {
    let self = this;
    $(document).ready(function () {
      self.ringingPhoneFunc();
    });
    this.startBasicCall();
  },
  methods: {
    async startBasicCall() {
      // Create an instance of the Agora Engine
      const agoraEngine = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
      // Dynamically create a container in the form of a DIV element to play the remote video track.
      const remotePlayerContainer = document.createElement("div");
      // Dynamically create a container in the form of a DIV element to play the local video track.
      const localPlayerContainer = document.createElement("div");
      // Specify the ID of the DIV container. You can use the uid of the local user.
      localPlayerContainer.id = this.options.uid;
      // Listen for the "user-published" event to retrieve a AgoraRTCRemoteUser object.
      let self = this;
      agoraEngine.on("user-published", async (user, mediaType) => {
        // Subscribe to the remote user when the SDK triggers the "user-published" event.
        await agoraEngine.subscribe(user, mediaType);
        console.log("subscribe success");
        // Subscribe and play the remote video in the container If the remote user publishes a video track.
        if (mediaType == "video") {
          console.log("remote");
          // Retrieve the remote video track.
          self.channelParameters.remoteVideoTrack = user.videoTrack;
          // Retrieve the remote audio track.
          self.channelParameters.remoteAudioTrack = user.audioTrack;
          // Save the remote user id for reuse.
          self.channelParameters.remoteUid = user.uid.toString();
          // Specify the ID of the DIV container. You can use the uid of the remote user.
          remotePlayerContainer.id = user.uid.toString();
          self.channelParameters.remoteUid = user.uid.toString();
          /*remotePlayerContainer.textContent = "Remote user " + user.uid.toString();*/
          // Append the remote container to the page body.
          self.$refs.ringingPhone.pause();
          document.body.append(remotePlayerContainer);
          $(".remotePlayerDiv").html(remotePlayerContainer);
          $(".remotePlayerDiv").removeAttr("style").css("display", "unset");
          $(remotePlayerContainer).addClass("remotePlayerLayer");
          // Play the remote video track.
          self.channelParameters.remoteVideoTrack.play(remotePlayerContainer);
        }
        // Subscribe and play the remote audio track If the remote user publishes the audio track only.
        if (mediaType == "audio") {
          // Get the RemoteAudioTrack object in the AgoraRTCRemoteUser object.
          self.channelParameters.remoteAudioTrack = user.audioTrack;
          // Play the remote audio track. No need to pass any DOM element.
          self.channelParameters.remoteAudioTrack.play();
        }
        // Listen for the "user-unpublished" event.
        agoraEngine.on("user-unpublished", (user) => {
          console.log(user.uid + "has left the channel");
        });
      });
      window.onload = function () {
        self.joinVideo(
          agoraEngine,
          self.channelParameters,
          localPlayerContainer,
          self
        );
      };
    },
    getUrlVars() {
      var vars = [],
        hash;
      var hashes = window.location.href
        .slice(window.location.href.indexOf("?") + 1)
        .split("&");
      for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split("=");
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
      }
      return vars;
    },
    async joinVideo(
      agoraEngine,
      channelParameters,
      localPlayerContainer,
      self
    ) {
      console.log("local");
      // Join a channel.
      await agoraEngine.join(
        self.options.appId,
        self.options.channel,
        self.options.token,
        self.options.uid
      );
      // Create a local audio track from the audio sampled by a microphone.
      channelParameters.localAudioTrack =
        await AgoraRTC.createMicrophoneAudioTrack();
      // Create a local video track from the video captured by a camera.
      channelParameters.localVideoTrack =
        await AgoraRTC.createCameraVideoTrack();
      // Append the local video container to the page body.
      document.body.append(localPlayerContainer);
      $(".localPlayerDiv").html(localPlayerContainer);
      $(localPlayerContainer).addClass("localPlayerLayer");
      // Publish the local audio and video tracks in the channel.
      await agoraEngine.publish([
        channelParameters.localAudioTrack,
        channelParameters.localVideoTrack,
      ]);
      // Play the local video track.
      channelParameters.localVideoTrack.play(localPlayerContainer);
      console.log("publish success!");
    },
    leaveChannel() {
      if (confirm("Are you sure you want to leave this channel?")) {
        window.top.close();
      }
    },
    videoStreamingOnAndOff() {
      this.videoStreaming = this.videoStreaming ? false : true;
      this.channelParameters.localVideoTrack.setEnabled(this.videoStreaming);
    },
    audioStreamingOnAnddOff() {
      this.audioStreaming = this.audioStreaming ? false : true;
      this.channelParameters.localAudioTrack.setEnabled(this.audioStreaming);
    },
    // hideDivAfterTimeout() {
    // setTimeout(() => {
    //   $(".iconCall").removeClass("fade-in");
    //   this.showDiv = false;
    // }, 10000);
    // },
    showDivAgain() {
      this.showDiv = true;
      //  this.hideDivAfterTimeout();
    },
    clearTimeout() {
      // Clear the timeout if the component is about to be unmounted
      // to prevent memory leaks
      clearTimeout(this.timeoutId);
    },
    async ringingPhoneFunc() {
      await this.$refs.ringingPhone.play();
      let self = this;
      setTimeout(function () {
        console.log("pause");
        self.$refs.ringingPhone.pause();
      }, 60000);
    },

    //--------------------------------------------------------------------------

    generatePrescription() {
      const getPrescription = {
        code: this.referral_code,
        form_type: this.form_type,
        tracking_id: this.tracking_id,
      };
      console.log(getPrescription);

      axios
        .post(`${this.baseUrl}/api/video/prescription/check`, getPrescription)
        .then((response) => {
          console.log(response);
          if (response.data.status === "success") {
            const prescriptions =
              response.data.prescriptions[0].prescribed_activity_id;

            console.log("Prescriptions:", prescriptions);

            const prescribedActivityId = prescriptions;
            window.open(
              `${this.baseUrl}/doctor/print/prescription/${this.tracking_id}/${prescribedActivityId}`,
              "_blank"
            );
          } else {
            Lobibox.alert("error", {
              msg: "No added prescription!",
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    endorseUpward() {
      let self = this;
      Lobibox.confirm({
        msg: "Do you want to endorse this patient for an upward level of referral?",
        callback: function ($this, type, ev) {
          if (type == "yes") {
            const endorseUpward = {
              code: self.referral_code,
              form_type: self.form_type,
            };
            axios
              .post(`${self.baseUrl}/api/video/upward`, endorseUpward)
              .then((response) => {
                console.log(response.status);
                console.log('data Upward:',response.data)
                console.log("endorseUpward:", endorseUpward);
                if (response.data.trim() === "success") {
                  Lobibox.alert("success", {
                    msg: "Successfully endorse the patient for upward referral!",
                  });
                } else {
                  Lobibox.alert("error", {
                    msg: "Error in server!",
                  });
                }
              });
          }
        },
      });
    },
    labRequest() {
      console.log("lab request");
    },
  },
};
</script>

<template>
  <audio ref="ringingPhone" :src="ringingPhoneUrl" loop></audio>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8">
        <div class="mainPic">
          <div class="remotePlayerDiv">
            <div id="calling">
              <h3>Calling...</h3>
            </div>
            <img :src="doctorUrl" class="img-fluid" alt="Image1" />
          </div>
          <Transition name="fade">
            <div class="tooltip-container">
              <div class="iconCall position-absolute fade-in" v-if="showDiv">
                <div class="button-container">
                  <div
                    v-if="showMic"
                    class="tooltip-text"
                    style="background-color: #138496"
                  >
                    Audio
                  </div>
                  <button
                    class="btn btn-info btn-lg mic-button"
                    :class="{ 'mic-button-slash': !audioStreaming }"
                    @click="audioStreamingOnAnddOff"
                    type="button"
                    @mouseover="showMic = true"
                    @mouseleave="showMic = false"
                  >
                    <i class="bi-mic-fill"></i>
                  </button>
                </div>
                &nbsp;
                <div class="button-container">
                  <div
                    v-if="showVedio"
                    class="tooltip-text"
                    style="background-color: #218838"
                  >
                    Video
                  </div>
                  <button
                    class="btn btn-success btn-lg video-button"
                    :class="{ 'video-button-slash': !videoStreaming }"
                    @click="videoStreamingOnAndOff"
                    type="button"
                    @mouseover="showVedio = true"
                    @mouseleave="showVedio = false"
                  >
                    <i class="bi-camera-video-fill"></i>
                  </button>
                </div>
                &nbsp;
                <div class="button-container">
                  <div
                    v-if="showEndcall"
                    class="tooltip-text"
                    style="background-color: #c82333"
                  >
                    End Call
                  </div>
                  <button
                    class="btn btn-danger btn-lg decline-button"
                    @click="leaveChannel"
                    type="button"
                    @mouseover="showEndcall = true"
                    @mouseleave="showEndcall = false"
                  >
                    <i class="bi-telephone-x-fill"></i>
                  </button>
                </div>
                &nbsp;
                <div class="button-container">
                  <div
                    v-if="showUpward"
                    class="tooltip-text"
                    style="background-color: #e0a800"
                  >
                    Upward
                  </div>
                  <button
                    class="btn btn-warning btn-lg upward-button"
                    @click="endorseUpward"
                    type="button"
                    v-if="referring_md == 'no'"
                    @mouseover="showUpward = true"
                    @mouseleave="showUpward = false"
                  >
                    <i class="bi-hospital"></i>
                  </button>
                </div>
                <div class="button-container">
                  <div
                    v-if="showPrescription"
                    class="tooltip-text"
                    style="background-color: #218838"
                  >
                    Prescription
                  </div>
                  <button
                    class="btn btn-success btn-lg prescription-button"
                    data-toggle="modal"
                    data-target="#prescriptionModal"
                    type="button"
                    v-if="referring_md == 'no'"
                    @mouseover="showPrescription = true"
                    @mouseleave="showPrescription = false"
                  >
                    <i class="bi bi-prescription"></i>
                  </button>
                </div>
                <div class="button-container">
                  <div
                    v-if="showTooltip"
                    class="tooltip-text"
                    style="background-color: #007bff"
                  >
                    lab Request
                  </div>
                  <button
                    class="btn btn-primary btn-lg prescription-button"
                    data-toggle="modal"
                    data-target="#labRequestModal"
                    type="button"
                    v-if="referring_md == 'no'"
                    @mouseover="showTooltip = true"
                    @mouseleave="showTooltip = false"
                  >
                    <i class="bi bi-prescription2"></i>
                  </button>
                </div>
              </div>
            </div>
          </Transition>
          <div class="localPlayerDiv">
            <img :src="doctorUrl1" id="local-image" class="img2" alt="Image2" />
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="telemedForm">
          <div class="row-fluid">
            <div>
              <img :src="dohLogoUrl" alt="Image3" class="dohLogo" />
            </div>
            <div class="formHeader">
              <p>Republic of the Philippines</p>
              <p>DEPARTMENT OF HEALTH</p>
              <p><b>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</b></p>
              <p>Osmeña Boulevard Sambag II, Cebu City, 6000 Philippines</p>
              <p>
                Regional Director's Office Tel. No. (032) 253-6355 Fax No. (032)
                254-0109
              </p>
              <p>
                Official Website:
                <span style="color: blue">http://www.ro7.doh.gov.ph</span> Email
                Address: dohro7@gmail.com
              </p>
            </div>
            <div class="clinical">
              <!-- <input type="text" id="activity_id" value=""> -->
              <span style="color: #4caf50"><b>CLINICAL REFERRAL FORM</b></span>
            </div>
            <div class="tableForm">
              <table class="table table-striped formTable">
                <tbody>
                    <tr>
                    <td colspan="12">
                        Name of Referring Facility:
                        <span class="forDetails"> {{ form.referring_name }} </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Facility Contact #:
                        <span class="forDetails">
                        {{ form.referring_contact }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Address:
                        <span class="forDetails">
                        {{ form.referring_address }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="6">
                        Referred to:
                        <span class="forDetails"> {{ form.referred_name }} </span>
                    </td>
                    <td colspan="6">
                        Department:
                        <span class="forDetails"> {{ form.department }} </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Address:
                        <span class="forDetails">
                        {{ form.referred_address }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="6">
                        Date/Time Referred (ReCo):
                        <span class="dateReferred"> {{ form.time_referred }} </span>
                    </td>
                    <td colspan="6">
                        Date/Time Transferred:<span class="forDetails">
                        {{ form.time_transferred }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="4">
                        Name of Patient:
                        <span class="forDetails"> {{ form.patient_name }} </span>
                    </td>
                    <td colspan="4">
                        Age: <span class="forDetails"> {{ patient_age }} </span>
                    </td>
                    <td colspan="4">
                        Sex:
                        <span class="forDetails"> {{ form.patient_sex }} </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="6">
                        Address:
                        <span class="forDetails"> {{ form.patient_address }} </span>
                    </td>
                    <td colspan="6">
                        Status:
                        <span class="forDetails"> {{ form.patient_status }} </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="6">
                        Philhealth status:
                        <span class="forDetails"> {{ form.phic_status }} </span>
                    </td>
                    <td colspan="6">
                        Philhealth #:
                        <span class="forDetails"> {{ form.phic_id }} </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Covid Number:
                        <span class="forDetails"> {{ form.covid_number }} </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Clinical Status:
                        <span class="forDetails">
                        {{ form.refer_clinical_status }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Surviellance Category:
                        <span class="forDetails">
                        {{ form.refer_sur_category }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Case Summary (pertinent Hx/PE, including meds, labs, course
                        etc.): <br /><span class="caseforDetails">{{
                        form.case_summary
                        }}</span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Summary of ReCo (pls. refer to ReCo Guide in Referring
                        Patients Checklist):<br /><span class="recoSummary">
                        {{ form.reco_summary }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        ICD-10 Code and Description:
                        <li v-for="i in icd">
                        <span class="caseforDetails"
                            >{{ i.code }} - {{ i.description }}</span
                        >
                        </li>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Reason for referral:
                        <span class="forDetails">
                        {{ form.other_reason_referral }}
                        </span>
                    </td>
                    </tr>
                    <tr v-if="file_path">
                    <td colspan="12">
                        <span v-if="file_path.length > 1">File Attachments: </span>
                        <span v-else>File Attachment: </span>
                        <span v-for="(path, index) in file_path" :key="index">
                        <a
                            :href="path"
                            :key="index"
                            id="file_download"
                            class="reason"
                            target="_blank"
                            download
                            >{{ file_name[index] }}</a
                        >
                        <span v-if="index + 1 !== file_path.length">,&nbsp;</span>
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Name of Referring MD/HCW:
                        <span class="forDetails"> {{ form.md_referring }} </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Contact # of Referring MD/HCW:
                        <span class="forDetails">
                        {{ form.referring_md_contact }}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="12">
                        Name of referred MD/HCW-Mobile Contact # (ReCo): <br /><span
                        class="mdHcw"
                        >
                        {{ form.md_referred }}
                        </span>
                    </td>
                    </tr>
                </tbody>
              </table>
              <div v-if="referring_md == 'yes'">
                <button
                  class="btn btn-success btn-md btn-block"
                  type="button"
                  @click="generatePrescription()"
                >
                  <i class="bi bi-prescription"></i> Generate Prescription
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <PrescriptionModal
      :activity_id="parseInt(activity_id)"
      :baseUrl="baseUrl"
      :code="referral_code"
      :form_type="form_type"
    />
    <LabRequestModal
      :activity_id="parseInt(activity_id)"
      :requested_by="parseInt(user.id)"
    />
  </div>
</template>

<style scoped>
@import "./css/index.css";
</style>
