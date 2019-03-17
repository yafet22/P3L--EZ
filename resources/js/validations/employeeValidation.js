import { 
    required,
    maxLength,
    numeric
} from 'vuelidate/lib/validators'

export default {
    form: {
        first_name: { required },
        last_name: {},
        address: { required },
        phone_number: {
            required,
            maxLength: maxLength(12),
            numeric
        },
        salary: {
            required,
            numeric
        },
        id_branch: { required },
        id_role: { required }
    }
}