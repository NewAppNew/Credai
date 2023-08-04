import React, { Fragment, useEffect, useState } from 'react'
import PageComponent from '../../components/PageComponent'
import { ArrowLeftCircleIcon, InboxArrowDownIcon } from '@heroicons/react/24/solid'
import Card from '../helpers/Card'
import Label from '../helpers/Label'
import Input from '../helpers/Input'
import Button from '../helpers/Button'
import LinkButton from '../helpers/LinkButton'
import Loader from '../Common/Loader'
import axiosClient from '../../Axios'
import Validation from '../helpers/Validation'
import CustomSelect from '../helpers/CustomSelect'
import TextArea from '../helpers/TextArea'
import { useNavigate, useParams } from 'react-router-dom'
import { useStateContext } from '../../context/ContextProvider'
import flasher from '@flasher/flasher'

function AddNewWork() {
    const { id } = useParams()
    if (id) {
        document.title = 'SiteSmart - Edit Work'
    } else {
        document.title = 'SiteSmart - Add New Work'
    }

    const [loader, setLoader] = useState(false)
    const [errors, setErrors] = useState([])
    const navigate = useNavigate()
    const { FRONTEND_URL, BACKEND_URL } = useStateContext()

    const [cadImage, setCadImage] = useState('');
    const cadImageChange = (e) => {
        setCadImage(e.target.files[0]);
    }

    const [formInfo, setFormInfo] = useState({
        work_name: '',
        work_location: '',
        work_category: '',
        budget_amount: '',
        completion_date: '',
        work_status: '',
        start_date: '',
        assigned_supervisor: '',
        work_description: '',
        rera_registration:'',
        amenities:'',
    })
    const handleChange = (e) => {
        setFormInfo(formInfo => ({
            ...formInfo,
            [e.target.name]: e.target.value
        }))
    }
    const handleSubmit = (e) => {
        e.preventDefault()
        setLoader(true)
        const formData = new FormData()
        formData.append('work_name', formInfo.work_name)
        formData.append('work_location', formInfo.work_location)
        formData.append('work_category', formInfo.work_category)
        formData.append('completion_date', formInfo.completion_date)
        formData.append('work_status', formInfo.work_status)
        formData.append('start_date', formInfo.start_date)
        formData.append('assigned_supervisor', formInfo.assigned_supervisor)
        formData.append('work_description', formInfo.work_description)
        formData.append('budget_amount', formInfo.budget_amount)
        formData.append('rera_registration', formInfo.rera_registration)
        formData.append('amenities', formInfo.amenities)
        formData.append('cad_image', cadImage)
        console.log('formData :', formData);

        axiosClient.post(id ? `update_work/${id}` : '/store_work', formData)
            .then(({ data }) => {
                setLoader(false)
                flasher.success(data.msg)
                navigate('/work-management')
            })
            .catch(({ response }) => {
                setLoader(false)
                setErrors(response.data.errors)
            })
    }
    const getSingleWorkData = () => {
        setLoader(true)
        axiosClient.get(`/single_work_data/${id}`)
            .then(({ data }) => {
                setLoader(false)
                setFormInfo(data.single_data)
                setCadImage(data.single_data.cad_image)
            })
    }
    useEffect(() => {
        if (id) {
            getSingleWorkData()
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])
    return (
        <Fragment>
            {loader ? (<Loader />) : (
                <PageComponent title={id ? 'Edit Work' : 'Add New Work'} button={
                    <LinkButton to={'/work-management'}>
                        <ArrowLeftCircleIcon className='w-6 h-6' />
                        <span>Back To List</span>
                    </LinkButton>
                }>
                    <div className='flex items-center justify-center'>
                        <Card className="w-[60rem] p-4 bg-default-color ">
                            <form onSubmit={handleSubmit} className='mt-4'>
                                <div className='grid grid-cols-1 md:grid-cols-3 gap-x-6'>
                                    <div className='mb-3'>
                                        <Label htmlFor={'work_name'} labelText={'Work Name'} className={'mb-1'} />
                                        <Input id={'work_name'} type={'text'} name={'work_name'} value={formInfo.work_name} onChange={handleChange} onKeyPress={(event) => { if (!/[A-Za-z]| /.test(event.key)) { event.preventDefault() } }} />
                                        <Validation error={errors.work_name} />
                                    </div>
                                    <div className='mb-3'>
                                        <Label htmlFor={'work_location'} labelText={'Work Location'} className={'mb-1'} />
                                        <Input id={'work_location'} type={'text'} name={'work_location'} value={formInfo.work_location} onChange={handleChange} />
                                        <Validation error={errors.work_location} />
                                    </div>
                                    <div className='mb-3'>
                                        <Label htmlFor={'work_category'} labelText={'Work Category'} className={'mb-1'} />
                                        <CustomSelect id={'work_category'} name={'work_category'} value={formInfo.work_category} onChange={handleChange}>
                                            <option value={''}>--- Choose Work Category ---</option>
                                            <option value={'Residential'}>Residential</option>
                                            <option value={'Commercial'}>Commercial </option>
                                            <option value={'Bunglow'}>Bunglow</option>
                                            <option value={'Residential_Commercial'}>Residential & Commercial</option>
                                        </CustomSelect>
                                        <Validation error={errors.work_category} />
                                    </div>
                                </div>
                                <div className='grid grid-cols-1 md:grid-cols-3 gap-x-6'>
                                <div className='mb-3'>
                                        <Label htmlFor={'rera_registration'} labelText={'RERA Registration No.'} className={'mb-1'} />
                                        <Input id={'rera_registration'} type={'text'} name={'rera_registration'} value={formInfo.rera_registration} onChange={handleChange}/>
                                        <Validation error={errors.rera_registration} />
                                    </div>
                                    <div className='mb-3'>
                                        <Label htmlFor={'start_date'} labelText={'Estimated Start date'} className={'mb-1'} />
                                        <Input id={'start_date'} type={'date'} name={'start_date'} value={formInfo.start_date} onChange={handleChange} />
                                        <Validation error={errors.start_date} />
                                    </div>
                                    <div className='mb-3'>
                                        <Label htmlFor={'completion_date'} labelText={'Estimated Completion Date'} className={'mb-1'} />
                                        <Input id={'completion_date'} type={'date'} name={'completion_date'} value={formInfo.completion_date} onChange={handleChange} />
                                        <Validation error={errors.completion_date} />
                                    </div>
                                </div>
                                <div className='grid grid-cols-1 md:grid-cols-2 gap-x-6'>
                                    <div className='mb-3'>
                                        <Label htmlFor={'budget_amount'} labelText={'Budget Amount'} className={'mb-1'} />
                                        <Input id={'budget_amount'} type={'text'} name={'budget_amount'} value={formInfo.budget_amount} onChange={handleChange} onKeyPress={(event) => { if (!/[0-9]/.test(event.key)) { event.preventDefault(); } }} />
                                        <Validation error={errors.budget_amount} />
                                    </div>
                                    <div className='mb-3'>
                                        <Label htmlFor={'work_status'} labelText={'Work Status'} className={'mb-1'} />
                                        <CustomSelect id={'work_status'} name={'work_status'} value={formInfo.work_status} onChange={handleChange}>
                                            <option value={''}>--- Choose Work Status ---</option>
                                            <option value={'start'}>Start</option>
                                            <option value={'pending'}>Pending</option>
                                            <option value={'in_progress'}>In Progress</option>
                                            <option value={'completed'}>Completed</option>
                                        </CustomSelect>
                                        <Validation error={errors.work_status} />
                                    </div>
                                </div>
                                <div className='grid grid-cols-1 md:grid-cols-3 gap-x-6'>
                                    <div className='mb-3'>
                                        <Label htmlFor={'assigned_supervisor'} labelText={'Assigned Supervisor / Project Incharge'} className={'mb-1'} />
                                        <Input id={'assigned_supervisor'} type={'text'} name={'assigned_supervisor'} value={formInfo.assigned_supervisor} onChange={handleChange} onKeyPress={(event) => { if (!/[A-Za-z]| /.test(event.key)) { event.preventDefault() } }} />
                                        <Validation error={errors.assigned_supervisor} />
                                    </div>
                                    <div className='mb-3'>
                                        <Label htmlFor={'amenities'} labelText={'Amenities'} className={'mb-1'} />
                                        <Input id={'amenities'} type={'text'} name={'amenities'} value={formInfo.amenities} onChange={handleChange}/>
                                        <Validation error={errors.amenities} />
                                    </div>
                                    <div>
                                        <Label htmlFor={'work_description'} labelText={'Work Description'} className={'mb-1'} />
                                        <TextArea id={'work_description'} rows={2} name={'work_description'} value={formInfo.work_description} onChange={handleChange} onKeyPress={(event) => { if (!/[A-Za-z]| /.test(event.key)) { event.preventDefault() } }} />
                                        <Validation error={errors.work_description} />
                                    </div>
                                </div>
                                <div>
                                    <Label htmlFor={'cad_image'} labelText={'CAD Image'} />
                                    <img src={cadImage ? (
                                        cadImage.name ? URL.createObjectURL(cadImage) : BACKEND_URL + "/assets/images/CADFile/" + cadImage
                                    ) : FRONTEND_URL + "/assets/images/noimage.png"} alt="Cad-img" className='w-96 h-80 rounded' />
                                    <Input id={'cad_image'} type={'file'} name={'cad_image'} onChange={cadImageChange} className={'p-[0px!important] mt-2'} />
                                    <Validation error={errors.cad_image} />
                                </div>
                                <Button className={'w-60 mt-6 mx-auto'}>
                                    <span className="absolute inset-y-0 left-0 flex items-center pl-3"><InboxArrowDownIcon className="h-5 w-5 text-default-color" /></span>
                                    <span className='ml-5'>Save Now</span>
                                </Button>
                            </form>
                        </Card>
                    </div>
                </PageComponent>
            )}
        </Fragment>
    )
}


export default AddNewWork
