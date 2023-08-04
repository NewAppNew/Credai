import React, { useEffect, useState } from "react";
import {
  View,
  Text,
  SafeAreaView,
  ScrollView,
  RefreshControl,
  TextInput,
  Image,
  TouchableOpacity,
  Modal,
  Pressable,
  FlatList,
} from "react-native";
//import { BottomSheet } from "react-native-btr";
import * as ImagePicker from "expo-image-picker";
import { Appbar } from "react-native-paper";
import {
  launchCameraAsync,
  useCameraPermissions,
  PermissionStatus,
} from "expo-image-picker";

import DatePicker from "react-native-modern-datepicker";
import { getFormatedDate } from "react-native-modern-datepicker";

import { Ionicons, AntDesign } from "@expo/vector-icons";
//import { dashstyles } from '../Componants/DashboardStyle';
import { dashstyles, imageUploaderStyles } from "./Components/DashboardStyle";
import { Box, CheckIcon, NativeBaseProvider, Select } from "native-base";

import { atStyle, styles } from "./Components/LoginStyle";
import { useNavigation } from "@react-navigation/native";

const locations = [
  { location: "Paper", code: "93", iso: "AF" },
  { location: "Hoarding", code: "355", iso: "AL" },
  { location: "Radio", code: "35", iso: "AB" },
];
const AddAdvertisement = () => {
  const navigation = useNavigation();

  const [service, setService] = useState("");
  const [pickedImagePath, setPickedTaskImagePath] = useState("");
  const [openStartDatePicker, setOpenStartDatePicker] = useState(false);
  const [openToDatePicker, setOpenToDatePicker] = useState(false);
  const [selectedLocation, setSelectedLocation] = useState("");
  const [data, setData] = useState(locations);
  //const [date, setDate] = useState(new Date());

  const today = new Date();
  // const startDate =
  //   date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getYear();
  const startDate = getFormatedDate(
    today.setDate(today.getDate()),
    "YYYY/MM/DD"
  );
  const todayDate = getFormatedDate(
    today.setDate(today.getDate() - 1),
    "YYYY/MM/DD"
    //"DD/MM/YYYY"
  );
  const [selectedStartDate, setSelectedStartDate] = useState();
  const [startedDate, setStartedDate] = useState(todayDate);
  const [selectedToDate, setSelectedToDate] = useState();
  const [ToDate, setToDate] = useState(todayDate);
  const [clicked, setClicked] = useState(false);
  const [cameraPermissionInformation, requestPermission] =
    useCameraPermissions();
  function handleChangeStartDate(propDate) {
    setStartedDate(propDate);
  }
  // async function verifyPermission() {
  //   if (cameraPermissionInformation.status === PermissionStatus.UNDETERMINED) {
  //     const permissionResponse = await requestPermission();

  //     return permissionResponse.granted;
  //   }
  //   if (cameraPermissionInformation.status === PermissionStatus.DENIED) {
  //     Alert.alert(
  //       "Insufficient permission!",
  //       "You need to grant camera access to use this app"
  //     );
  //     return false;
  //   }
  //   return true;
  // }
  // async function camerapressHandler() {
  //   const hasPermission = await verifyPermission();
  //   if (!hasPermission) {
  //     return;
  //   }
  //   const image = await launchCameraAsync({
  //     allowsEditing: true,
  //     aspect: [16, 9],
  //     quality: 0.5,
  //   });
  //   setPickedTaskImagePath(image.assets);
  // }
  const handleOnPressToDate = () => {
    setOpenToDatePicker(!openToDatePicker);
  };
  function handleChangeToDate(propDate) {
    setToDate(propDate);
  }

  const handleOnPressStartDate = () => {
    setOpenStartDatePicker(!openStartDatePicker);
    setStartedDate("");
  };
  const handleCancelPress = () => {
    navigation.navigate("Marketing");
  };

  return (
    <>
      <Appbar.Header style={dashstyles.proheader} elevated="true">
        <Ionicons
          name="chevron-back"
          size={30}
          style={dashstyles.proicon}
          onPress={() => navigation.navigate("Marketing")}
        />
        <Appbar.Content
          titleStyle={dashstyles.proheadText}
          title="Add Advertisement"
        />
        <Appbar.Action
          style={dashstyles.proicon}
          color="#ffffff"
          icon="bell-outline"
          onPress={() => {}}
        />
      </Appbar.Header>
      <NativeBaseProvider>
        <View style={styles.mainBody}>
          <ScrollView>
            <View style={dashstyles.taskMarginForm}>
              <View>
                <Text style={atStyle.inputText}>Assigned Company</Text>
                <TextInput
                  style={styles.payBox}
                  underlineColorAndroid="transparent"
                  placeholder="Enter Company Name"
                  placeholderTextColor="#dadae8"
                  autoCapitalize="none"
                  //  value="Task 1"
                  // editable={true}
                />
              </View>

              {/* dropdown */}
              <View>
                <Text style={atStyle.inputText}>Type</Text>
                <TouchableOpacity
                  style={{
                    width: "99%",
                    height: 38,
                    borderRadius: 10,
                    borderWidth: 0.5,
                    alignSelf: "center",
                    marginTop: 6,
                    flexDirection: "row",
                    justifyContent: "space-between",
                    alignItems: "center",
                    paddingLeft: 2,
                    paddingRight: 2,
                    borderColor: "#DCDCDC",
                    color: "#000000",
                    marginTop: 1,
                    marginBottom: 10,
                  }}
                  onPress={() => {
                    setClicked(!clicked);
                  }}
                >
                  <Text
                    style={{
                      fontWeight: "600",
                      paddingLeft: 10,
                      placeholderTextColor: "#DCDCDC",

                      //color: "#DCDCDC",
                    }}
                  >
                    {selectedLocation == "" ? "Select Type" : selectedLocation}
                  </Text>
                  {clicked ? (
                    <Image
                      source={require("./upload.png")}
                      alt="description of image"
                      style={{ width: 20, height: 20, paddingRight: 10 }}
                    />
                  ) : (
                    <Image
                      source={require("./dropdown.png")}
                      alt="description of image"
                      style={{
                        width: 20,
                        height: 20,
                        paddingRight: 10,
                      }}
                    />
                  )}
                </TouchableOpacity>
                {clicked ? (
                  <View
                    style={{
                      elevation: 5,
                      marginTop: 10,

                      alignSelf: "center",
                      //width: "90%",
                      backgroundColor: "#fff",
                      borderRadius: 10,
                      width: "99%",
                    }}
                  >
                    {/* <TextInput
                  placeholder="Search.."
                  value={search}
                  ref={searchRef}
                  onChangeText={(txt) => {
                   // onSearch(txt);
                   // setSearch(txt);
                  }}
                  style={{
                    width: "90%",
                    height: 50,
                    alignSelf: "center",
                    borderWidth: 0.2,
                    borderColor: "#8e8e8e",
                    borderRadius: 7,
                    marginTop: 20,
                    paddingLeft: 20,
                  }}
                /> */}

                    <FlatList
                      data={data}
                      renderItem={({ item, index }) => {
                        return (
                          <TouchableOpacity
                            style={{
                              width: "85%",
                              alignSelf: "center",
                              height: 50,
                              justifyContent: "center",
                              borderBottomWidth: 0.5,
                              borderColor: "#8e8e8e",
                            }}
                            onPress={() => {
                              setSelectedLocation(item.location);
                              setClicked(!clicked);
                              //  onSearch("");
                              // setSearch("");
                            }}
                          >
                            <Text
                              style={{ fontWeight: "600", color: "#000000" }}
                            >
                              {item.location}
                            </Text>
                          </TouchableOpacity>
                        );
                      }}
                    />
                  </View>
                ) : null}
              </View>

              <View>
                <Text style={atStyle.inputText}>Email Address</Text>
                <TextInput
                  style={styles.payBox}
                  underlineColorAndroid="transparent"
                  placeholder="Enter Email Address"
                  placeholderTextColor="#dadae8"
                  autoCapitalize="none"
                />
              </View>

              {/* <View>
                <Text style={atStyle.inputText}>Date</Text>
                <TextInput
                  style={styles.payBox}
                  underlineColorAndroid="transparent"
                  placeholder="Enter Task Name"
                  placeholderTextColor="#dadae8"
                  autoCapitalize="none"
                  value="24/4/2023"
                  editable={true}
                />
              </View> */}

              {/* Date */}
              <View>
                <Text style={atStyle.inputText}>Date</Text>
                <TouchableOpacity onPress={handleOnPressStartDate}>
                  <TextInput
                    style={styles.payBox}
                    editable={false}
                    value={selectedStartDate}
                    placeholder="Select Date"
                    placeholderTextColor="#dadae8"
                  />
                </TouchableOpacity>
                {/* Create modal for date picker */}
                <Modal
                  animationType="slide"
                  transparent={true}
                  visible={openStartDatePicker}
                >
                  <View style={styles.modelcontainer}>
                    <View style={styles.centeredView}>
                      <DatePicker
                        mode="calendar"
                        minimumDate={startDate}
                        selected={startedDate}
                        onDateChanged={handleChangeStartDate}
                        onSelectedChange={(date) => setSelectedStartDate(date)}
                        options={{
                          backgroundColor: "#ffffff",
                          textHeaderColor: "#030084",
                          textDefaultColor: "#000000",
                          selectedTextColor: "#FFF",
                          mainColor: "#030084",
                          textSecondaryColor: "#030084",
                          borderColor: "rgba(122, 146, 165, 0.1)",
                        }}
                      />
                      <View style={{ flexDirection: "row" }}>
                        <TouchableOpacity
                          onPress={handleOnPressStartDate}
                          style={styles.inputModelBtn}
                        >
                          <Text style={{ color: "white", textAlign: "center" }}>
                            OK
                          </Text>
                        </TouchableOpacity>
                      </View>
                    </View>
                  </View>
                </Modal>
              </View>

              <Text style={atStyle.inputText}>Remark</Text>
              <TextInput
                style={styles.inputTextarea}
                multiline
                numberOfLines={4}
                underlineColorAndroid="transparent"
                placeholder="Enter Remark"
                placeholderTextColor="#dadae8"
                autoCapitalize="none"
              />

              <View
                style={{
                  flexDirection: "row",
                  alignItems: "flex-start",
                  marginTop: 15,
                }}
              >
                <TouchableOpacity
                  style={styles.buttonSubmit}
                  onPress={() => navigation.navigate("DashTask")}
                >
                  <Text style={styles.buttonSubmitText}>Submit</Text>
                </TouchableOpacity>
                <TouchableOpacity
                  style={styles.buttonCancel}
                  onPress={() => navigation.navigate("DashTask")}
                >
                  <Text style={styles.buttonSubmitText}>Cancel</Text>
                </TouchableOpacity>
              </View>
            </View>
          </ScrollView>
        </View>
      </NativeBaseProvider>
    </>
  );
};
export default () => {
  return (
    <NativeBaseProvider>
      <AddAdvertisement />
    </NativeBaseProvider>
  );
};
//export default CashScreen;
